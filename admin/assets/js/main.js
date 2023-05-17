(function () {
  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim();
    if (all) {
      return [...document.querySelectorAll(el)];
    } else {
      return document.querySelector(el);
    }
  };

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    if (all) {
      select(el, all).forEach((e) => e.addEventListener(type, listener));
    } else {
      select(el, all).addEventListener(type, listener);
    }
  };

  /**
   * Sidebar toggle
   */
  if (select(".toggle-sidebar-btn")) {
    on("click", ".toggle-sidebar-btn", function (e) {
      select("body").classList.toggle("toggle-sidebar");
    });
  }

  // Get the current URL of the page
  const currentUrl = window.location.href;

  // Get all the links in the sidebar
  const sidebarLinks = document.querySelectorAll(".sidebar-nav a");

  // Loop through each link and check if its href matches the current URL
  sidebarLinks.forEach((link) => {
    if (link.href === currentUrl) {
      // Add the active class to the link's parent li element
      link.parentNode.classList.add("active");
    }
  });

  /**
   * Live timer/clock
   */
  setInterval(updateTime, 1000);
  function updateTime() {
    // Send an AJAX request to get the current time
    $.ajax({
      url: "fetch/get_time.php",
      type: "GET",
      success: function (data) {
        // Update the clock with the new time
        $("#clock").html(data);
      },
    });
  }
})();
