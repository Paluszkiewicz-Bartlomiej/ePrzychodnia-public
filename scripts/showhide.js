function show(classToHide, idToDisplay, styleOfDisplay) {
  const elements = document.getElementsByClassName(classToHide);
  for (const e of elements) {
	e.style.display = 'none';
  }
  document.getElementById(idToDisplay).style.display = styleOfDisplay;
}