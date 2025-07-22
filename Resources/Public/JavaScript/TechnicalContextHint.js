/**
 * Technical Context Hint
 */

(function() {

    /**
     * Apply dynamic styles from data attributes
     */
    function applyDynamicStyles(contextElement) {
        const bgColor = contextElement.dataset.bgColor;
        const textColor = contextElement.dataset.textColor;
        const positionX = contextElement.dataset.positionX;
        const positionY = contextElement.dataset.positionY;

        if (bgColor) {
            contextElement.style.setProperty('--technical-context-bg-color', bgColor);
        }
        if (textColor) {
            contextElement.style.setProperty('--technical-context-text-color', textColor);
        }

        if (positionX) {
            const positionXMatch = positionX.match(/(top|bottom):\s*([^;]+)/);
            if (positionXMatch) {
                contextElement.style.setProperty(positionXMatch[1], positionXMatch[2]);
            }
        }
        if (positionY) {
            const positionYMatch = positionY.match(/(left|right):\s*([^;]+)/);
            if (positionYMatch) {
                contextElement.style.setProperty(positionYMatch[1], positionYMatch[2]);
            }
        }
    }

    /**
     * Initialize technical context hint functionality
     */
    function initTechnicalContextHint() {
        const contextElements = document.querySelectorAll('.technical-context');

        contextElements.forEach(function(contextElement) {
            applyDynamicStyles(contextElement);

            const closeButton = contextElement.querySelector('.technical-context__close');
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    contextElement.remove();
                });
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTechnicalContextHint);
    } else {
        initTechnicalContextHint();
    }
})();
