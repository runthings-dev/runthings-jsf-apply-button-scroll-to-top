(function () {
  // Find all apply buttons
  var buttons = document.querySelectorAll(".apply-filters__button");

  /**
   * Detect auto scroll target using JSF's existing data attributes
   *
   * @param {HTMLElement} applyContainer The .apply-filters container
   * @return {string|null} Target ID or null for window top
   */
  function detectAutoTarget(applyContainer) {
    // Read JSF's existing attributes (already on the DOM)
    var queryId = applyContainer.dataset.queryId;
    var contentProvider = applyContainer.dataset.contentProvider;

    // Cascade: query_id → provider wrapper → null

    // 1. Try query_id first (if not 'default')
    if (queryId && queryId !== "default") {
      var queryElement = document.getElementById(queryId);
      if (queryElement) {
        return queryId;
      }
    }

    // 2. Try to find provider wrapper by selector
    var providerSelectors = {
      "jet-engine": ".jet-listing-grid.jet-listing",
      "jet-woo-builder": ".jet-woo-builder-products",
    };

    var selector = providerSelectors[contentProvider];
    if (selector) {
      var providerElement = document.querySelector(selector);
      if (providerElement && providerElement.id) {
        return providerElement.id;
      }
    }

    // 3. Fallback to window top
    return null;
  }

  /**
   * Perform scroll to target
   *
   * @param {string|null} targetId Target element ID (without #) or null for window top
   */
  function scrollToTarget(targetId) {
    // Strip any leading # from targetId (defensive)
    if (targetId) {
      targetId = targetId.replace(/^#/, "");
    }

    if (!targetId) {
      // Scroll to window top
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    } else {
      // Scroll to element with ID
      var element = document.getElementById(targetId);
      if (element) {
        element.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      } else {
        // Fallback to window top if element not found
        window.scrollTo({
          top: 0,
          behavior: "smooth",
        });
      }
    }
  }

  // Attach click handlers to all apply buttons
  buttons.forEach(function (btn) {
    btn.addEventListener("click", function () {
      // Find the widget wrapper with our data attribute
      var widget = btn.closest("[data-runthings-scroll-target]");
      if (!widget) {
        return;
      }

      var scrollTarget = widget.dataset.runthingsScrollTarget;

      // Handle auto-detection marker
      if (scrollTarget === "#__AUTO__") {
        // Find the .apply-filters container (has JSF's data attributes)
        var applyContainer = widget.querySelector(".apply-filters");
        if (applyContainer) {
          var autoTarget = detectAutoTarget(applyContainer);
          scrollToTarget(autoTarget);
        } else {
          scrollToTarget(null);
        }
      }
      // Handle explicit window top (empty string)
      else if (scrollTarget === "") {
        scrollToTarget(null);
      }
      // Handle specific target ID
      else {
        scrollToTarget(scrollTarget);
      }
    });
  });
})();
