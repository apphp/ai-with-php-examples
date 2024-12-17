
window.dd = function(...data) {
  if (data.length > 2) {
    console.log("%cdebug: ", "color:Orange");
    data.map((item) => console.log(item));
    console.groupEnd();
  } else {
    console.log("%cdebug: ", "color:Orange", ...data);
  }
};


