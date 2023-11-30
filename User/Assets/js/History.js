// custom-back.js

function customBack() {
    window.history.back();
  }
  
  // Replace the default browser back button functionality
  function replaceBrowserBack() {
    window.history.pushState({ page: 'customBack' }, '', ''); // Adds a new history entry
    window.onpopstate = function (event) {
      if (event.state && event.state.page === 'customBack') {
        customBack();
      }
    };
  }
  
  replaceBrowserBack();
  