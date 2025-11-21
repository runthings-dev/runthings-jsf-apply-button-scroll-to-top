(function () {
  // Find all apply buttons
  const buttons = document.querySelectorAll(".apply-filters__button");

  /**
   * Resolve element reference from ID
   *
   * @param {string} elementId Element ID (without #)
   * @return {HTMLElement|null} Element or null if not found
   */
  function resolveElementById(elementId) {
    if (!elementId) {
      return null;
    }
    return document.getElementById(elementId);
  }

  /**
   * Resolve element reference using JSF selector configuration
   *
   * @param {HTMLElement} applyContainer The .apply-filters container with JSF data attributes
   * @return {HTMLElement|null} Element or null if not found
   */
  function resolveElementFromJsfConfig(applyContainer) {
    // Read JSF's existing attributes (already on the DOM)
    const queryId = applyContainer.dataset.queryId;
    const contentProvider = applyContainer.dataset.contentProvider;

    // Cascade: query_id → provider wrapper → null

    // 1. Try query_id first (if not 'default')
    if (queryId && queryId !== "default") {
      const queryElement = document.getElementById(queryId);
      if (queryElement) {
        return queryElement;
      }
    }

    // 2. Try to find provider wrapper using JSF's selector configuration
    if (
      contentProvider &&
      window.JetSmartFilterSettings &&
      window.JetSmartFilterSettings.selectors &&
      window.JetSmartFilterSettings.selectors[contentProvider]
    ) {
      const selectorConfig =
        window.JetSmartFilterSettings.selectors[contentProvider];
      const selector = selectorConfig.selector;

      if (selector) {
        const providerElement = document.querySelector(selector);
        if (providerElement) {
          return providerElement;
        }
      }
    }

    // 3. Not found
    return null;
  }

  /**
   * Resolve scroll target instruction to element reference
   *
   * @param {string} scrollTarget The scroll target instruction from data attribute
   * @param {HTMLElement} widget The widget wrapper element
   * @return {HTMLElement|null} Element to scroll to, or null for window top
   */
  function resolveScrollTarget(scrollTarget, widget) {
    // Auto-detect using JSF configuration
    if (scrollTarget === "#__AUTO__") {
      const applyContainer = widget.querySelector(".apply-filters");
      if (applyContainer) {
        return resolveElementFromJsfConfig(applyContainer);
      }
      return null;
    }

    // Specific ID provided
    if (scrollTarget && scrollTarget !== "") {
      // Strip any leading # (defensive)
      const elementId = scrollTarget.replace(/^#/, "");
      return resolveElementById(elementId);
    }

    // Empty string or null = window top
    return null;
  }

  /**
   * Scroll to element or window top
   *
   * @param {HTMLElement|null} element Element to scroll to, or null for window top
   */
  function scrollToElement(element) {
    if (element) {
      element.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
    } else {
      // Scroll to window top
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    }
  }

  // Attach click handlers to all apply buttons
  buttons.forEach(function (btn) {
    btn.addEventListener("click", function () {
      // Find the widget wrapper with our data attribute
      const widget = btn.closest("[data-runthings-scroll-target]");
      if (!widget) {
        return;
      }

      const scrollTarget = widget.dataset.runthingsScrollTarget;
      const targetElement = resolveScrollTarget(scrollTarget, widget);
      scrollToElement(targetElement);
    });
  });
})();
