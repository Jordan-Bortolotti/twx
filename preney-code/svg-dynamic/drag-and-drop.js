var debug = true;             // Only for debugging purposes
var svgNS = "http://www.w3.org/2000/svg";
var svgDoc = null;           // init() sets to root element


//
// MouseDrag
// class
//
// MouseDrag holds information relevant when the mouse is dragging an
// object.
//
function MouseDrag() {
  var retval = {
    reset: function() { 
      this.sourceObject = null;
      this.originalMouseDownPoint = null;
      this.inverseTransformMatrix = null;
    }
  };
  retval.reset();
  return retval;
}


//
// getEventPoint(event)
// function
//
// Given an event, getEventPoint(evt) returns an SVGPoint for that event's
// mouse (X,Y) position.
//
function getEventPoint(evt)
{
  var pt = svgDoc.createSVGPoint();
  pt.x = evt.clientX;
  pt.y = evt.clientY;
  return pt;
}


//
// computeCTMString(ctm)
// function
//
// Given an SVG current transformation matrix (CTM), this function returns
// a string suitable for the attribute transform or null if ctm is null.
//
// See: http://www.w3.org/TR/SVG/coords.html
//      http://www.w3.org/Graphics/SVG/IG/resources/svgprimer.html
//        (See "Special Functions".)
//
// The CTM is the following 3x3 matrix:
//
//   | a b e |
//   | c d f |
//   | 0 0 1 |
//
// where (e,f) is the translation amount.
//
function computeCTMString(ctm)
{
  return ctm 
    ? "matrix("+ctm.a+","+ctm.b+","+ctm.c+","+ctm.d+","+ctm.e+","+ctm.f+")"
    : null
  ;
}


//
// setCTM(elem, ctm)
// function
//
// Given an SVG element, elem, and a current transformation matrix, ctm, 
// this function will set the transform attribute of the element to the
// ctm (converted to a string).
//
function setCTM(elem, ctm)
{
  if (elem != null && ctm != null)
    elem.setAttributeNS(null, "transform", computeCTMString(ctm));
}


//
// addRotateAboutCentreTransform(elem, dir, dur, repeatCount)
// function
//
// This function will make the SVG element, elem, rotate about its centre
// in direction, dir (1=clockwise, -1=counter clockwise); duration, dur;
// using repeatCount.
//
// This cannot be done directly in SVG unless one knows the centre point
// that the rotation is to be done. Thus, this function uses getBBox()
// to determine the centre of elem.
//
function addRotateAboutCentreTransform(elem, id, dir, dur, repeatCount)
{
  var svgDoc = elem.ownerDocument; 
  var animElem = svgDoc.createElementNS(svgNS, "animateTransform");
  animElem.setAttributeNS(null, "id", id);
  animElem.setAttributeNS(null, "attributeName", "transform");
  animElem.setAttributeNS(null, "attributeType", "XML");
  animElem.setAttributeNS(null, "type", "rotate");
  animElem.setAttributeNS(null, "dur", dur+"s");

  //animElem.setAttributeNS(null, "fill", "freeze");
  //animElem.setAttributeNS(null, "begin", "mouseout");
  //animElem.setAttributeNS(null, "end", "mouseover");
  //animElem.setAttributeNS(null, "restart", "always");

  animElem.setAttributeNS(null, "repeatCount", repeatCount);

  var bbox = elem.getBBox();
  var cx = bbox.x + bbox.width/2;
  var cy = bbox.y + bbox.height/2;

  animElem.setAttributeNS(null, "to", 360*dir+" "+cx+" "+cy);
  animElem.setAttributeNS(null, "from", "0 "+cx+" "+cy);
  elem.appendChild(animElem);
  animElem.beginElement();
  return animElem;
}


//
// updateRotateAboutCentreTransform(elem, animElem, dir)
// function
//
// This function allows window resize events to be easily handlerd for
// addRotateAboutCentreTransform.
//
function updateRotateAboutCentreTransform(elem, animElem)
{
  var bbox = elem.getBBox();
  var cx = bbox.x + bbox.width/2;
  var cy = bbox.y + bbox.height/2;

  var to_text = animElem.getAttribute("to");
  var dir = (to_text.charAt(0) == '-') ? -1 : 1;
  animElem.setAttributeNS(null, "to", 360*dir+" "+cx+" "+cy);
  animElem.setAttributeNS(null, "from", "0 "+cx+" "+cy);
}


//===========================================================================
// The rest of this file handlers event listening of various mouse events.
// This provides the interactivity with the SVG page that the user 
// experiences.
//===========================================================================


//===========================================================================
// Declare global variables for the various event handlerrs.
//===========================================================================
var mouseIsDown = false;            // Is true if the mouse button is down.
var mouseDrag = new MouseDrag();    // Holds object dragging information.
var selectedInkwell = null;         // Points to selected inkwell.
var circle_is_paused = null;        // Points to paused element

//
// inks[]
// array
//
// The inks array defines all ink colour strings. These are used to access
// the various ink wells by id, etc. to install the appropriate event
// listener(s).
//
var inks = [ 
  "red", "green", "blue", "cyan", "magenta", "yellow", "white", "black" ];

//
// shapes[]
// array
//
// The shapes array defines the ids of all shapes on the page the user can
// interact with.
//
var shapes = [ 
  "big-triangle", "normal-triangle", "text", "pacman", "updatename",
  "star" 
];


//===========================================================================
// Declare some helper functions for the various event handlerrs.
//===========================================================================


//
// getSelectedInkwellCSSClass()
// function
//
// This function retrieves the CSS class(es) for the selected inkwell so
// such can be used to set a shape's class.
//
function getSelectedInkwellCSSClass()
{
  if (selectedInkwell == null)
    return null;

  // The inkwell's <use> node class setting is the desired inkwell style...
  return selectedInkwell.getAttribute("class");
}


//
// selectInkwell(elem)
// function
//
// When given an inkwell SVG element, this function will change the
// inkwell's default stroke to be dashed (deselecting any previously
// selected inkwell).
//
function selectInkwell(elem)
{
  if (elem != null)
  {
    // De-highlight any previously selected inkwell...
    deselectInkwell();
    if (selectedInkwell)
      selectedInkwell.style.strokeDasharray = null;

    // And remember this new inkwell...
    selectedInkwell = elem;
    selectedInkwell.style.strokeDasharray = "6,6";
  }
  else
    deselectInkwell();
}


//
// deselectInkwell()
// function
//
// This function deselects any previously selected inkwell (by reverting
// its stroke back to normal).
//
function deselectInkwell()
{
  // De-highlight any previously highlighted inkwell...
  if (selectedInkwell)
    selectedInkwell.style.strokeDasharray = null;

  // Stop remembering the inkwell...
  selectedInkwell = null;
}


//===========================================================================
// The remaining code are all event handlerrs and init().
//===========================================================================


//
// handlerToSelectInkwell(event)
// function
//
// Given an event triggered on an inkwell object, this function selects
// the inkwell.
//
function handlerToSelectInkwell(evt)
{
  if (debug) console.log("handlerToSelectInkwell(): "+evt);

  evt.returnValue = false;
  selectInkwell(evt.currentTarget);
}


//
// handlerToDeselectInkwell(event)
// function
//
// Given an event, this function deselects any previously selected inkwell.
//
function handlerToDeselectInkwell(evt)
{
  if (debug) console.log("handlerToDeselectInkwell(): "+evt);

  evt.returnValue = false;
  deselectInkwell(evt.currentTarget);
}


//
// handlerSetShapeToInkwellCSSClass(event)
// function
//
// Given an event (triggered on a shape object) this function determines
// if the CSS class of the currently selected inkwell (if any), applies
// that to the shape, and deselects the current inkwell.
//
function handlerSetShapeToInkwellCSSClass(evt)
{
  evt.returnValue = false;
  if (selectedInkwell == null) return;
  var event_shape = evt.currentTarget; if (event_shape == null) return;
  if (debug) console.log("handlerSetShapeToInkwellCSSClass(): "+evt);

  // Acquire the colour...
  var col = getSelectedInkwellCSSClass();
  if (col == null) return;

  // If event_shape is id="text", then only apply to the text...
  if (event_shape.getAttribute("id") == "text")
  {
    var txt = document.getElementById("actual-text");
    txt.setAttributeNS(null, "class", col);
  }
  else
    // Apply to class to the event_shape...
    event_shape.setAttributeNS(null, "class", col);

  // Deselect the inkwell colour...
  deselectInkwell();
}


//
// handlerMouseDownToDrag(event)
// function
//
// Given an event (triggered on a shape) this function sets the global
// mouseDrag to contain the required information to drag-and-drop the shape
// anywhere on the screen.
//
function handlerMouseDownToDrag(evt)
{
  evt.returnValue = false;

  var elem = evt.currentTarget; // Obtain what was clicked on.
  if (elem)
  {
    // Remember the source object...
    mouseDrag.sourceObject = elem;

    // Acquire the inverse of the current transformation matrix for elem...
    mouseDrag.inverseTransformMatrix = elem.getCTM().inverse();

    //
    // Now perform these steps:
    //
    //   1) Get the mouse's (X,Y) position.
    //   2) Compute the source object's upper-left corner.
    //
    // Item (2) is needed to properly adjust the relative amount of
    // translation needed to move the dragged object.
    //
    var ctm = elem.getScreenCTM();
    var mousePt = getEventPoint(evt);
    mousePt.x = mousePt.x - ctm.e;
    mousePt.y = mousePt.y - ctm.f;

    // Convert mousePt to the CTM's coordinate system...
    mouseDrag.originalMouseDownPoint = 
      mousePt.matrixTransform(mouseDrag.inverseTransformMatrix);
  }

  // Record that the mouse is down last (to prevent a race conditions with
  // the above code)...
  mouseIsDown = true;

  if (debug)
    console.log("mouseDown(): "+evt);
}


//
// handlerDragShape(event)
// function
//
// Given an event, if the global mouseIsDown is true and mouseDrag is valid,
// then this function handlers the dragging of a shape.
//
function handlerDragShape(evt)
{
  evt.returnValue = false;

  // The mouse should be down, if not, abort...
  if (!mouseIsDown)
    return;

  if (debug)
    console.log("handlerDragShape(): "+evt);

  // Check to see if dragging needs to be handlerd...
  var elem = evt.currentTarget;
  if (elem
    && mouseDrag.sourceObject 
    && mouseDrag.originalMouseDownPoint
    && mouseDrag.inverseTransformMatrix) 
  {
    // Compute where the mouse is...
    var pt = getEventPoint(evt).
      matrixTransform(mouseDrag.inverseTransformMatrix);

    // And move the object to that location...
    setCTM(
      mouseDrag.sourceObject,
      svgDoc.createSVGMatrix()
        .translate(
          pt.x - mouseDrag.originalMouseDownPoint.x,
          pt.y - mouseDrag.originalMouseDownPoint.y
        )
    );

    // NOTE: 
    //   CTM matrix multiple is .multiple(mouseDragITM).
    //   One can also .scale(), .rotate(), etc.
  }
}


//
// handlerDropShape(event)
// function
//
// Since the shape is already correctly position, this handlerr when invoked
// resets mouseIsDown and mouseDrag to stop any further dragging of the
// selected shape.
//
function handlerDropShape(evt)
{
  evt.returnValue = false;
  mouseIsDown = false;
  mouseDrag.reset();

  if (debug)
    console.log("handlerDropShape(): "+evt);
}


//
// handlerWindowResize(event)
// function
//
// This function is invoked when the window resizes. Some things on the
// SVG page must be recomputed when such occurs to keep everything where it
// should be.
//
function handlerWindowResize(evt)
{
//ext-circle
  // Update old text-rotate...
  var elem = document.getElementById("text-rotate");
  var id = document.getElementById("text-rotate-anim");
  updateRotateAboutCentreTransform(elem, id);
}

function handlerPauseAnimations(evt)
{
  svgDoc.pauseAnimations();

  if (debug)
    console.log("handlerPauseAnimations(): "+evt);
}

function handlerUnpauseAnimations(evt)
{
  svgDoc.unpauseAnimations();

  if (debug)
    console.log("handlerUnpauseAnimations(): "+evt);
}

var counter = 0;
function handlerUpdateName(evt)
{
  var elem = document.getElementById("name");
  if (elem == null)
    return;
  
  // The name only has 1 child element (a text element) so we can just
  // keep replacing it...
  ++counter;
  elem.replaceChild(
    document.createTextNode(counter + " Paul Preney"),
    elem.childNodes[0]
  );

  if (debug)
    console.log("handlerUpdateName(): "+evt);
}


//
// init()
// function
//
// This function ensures all global variables are properly initialized and
// all necessary event listeners are installed. This must be called by the
// page's onload function when the page is ready.
//
function init()
{
  // Set global svgDoc variable...
  svgDoc = document.documentElement;
  if (svgDoc == null)
    return;
  
  svgDoc.addEventListener("mousemove", handlerDragShape, false);
  svgDoc.addEventListener("mouseup", handlerDropShape, false);

  // For cross-browser support of onresize, use window.onresize...
  window.onresize = handlerWindowResize;

  // Set up inkwell listeners...
  for (var i=0; i<inks.length; ++i)
  {
    var inkwell = document.getElementById("inkwell-"+inks[i]);
    if (inkwell)
      inkwell.addEventListener("click", handlerToSelectInkwell, false);
  }

  // Set up noinkwell listener...
  {
    var noinkwell = document.getElementById("noinkwell");
    if (noinkwell)
      noinkwell.addEventListener("click", handlerToDeselectInkwell, false);
  }

  // Set up shape listeners...
  for (var i=0; i<shapes.length; ++i)
  {
    var shape = document.getElementById(shapes[i]);
    if (shape)
    {
      shape.addEventListener("mousedown", handlerMouseDownToDrag, false);
      shape.addEventListener("click", handlerSetShapeToInkwellCSSClass, false);
    }
  }

  // Have the id=text's text-rotate rotate...
  var textElem = document.getElementById("text-rotate");
  if (textElem != null)
  {
    addRotateAboutCentreTransform(
      textElem, "text-rotate-anim", -1, 10, "indefinite"
    );

    textElem.addEventListener("mouseover", handlerPauseAnimations, false);
    textElem.addEventListener("mouseout", handlerUnpauseAnimations, false);
  }
  
  var updateNameElem = document.getElementById("updatename");
  if (updateNameElem != null)
  {
    updateNameElem.addEventListener("click", handlerUpdateName, false);
  }
}
