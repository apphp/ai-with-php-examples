function loadTooltips() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
}

loadTooltips();


function copyToClipboard(copyButtonId = 'copyButton') {
    // Find the <pre> tag content
    const codeContent = document.getElementById(copyButtonId + '-code').innerText;

    // Create a temporary textarea element to hold the content
    const tempTextArea = document.createElement("textarea");
    tempTextArea.value = codeContent.replaceAll(" ", " ");

    // Append the textarea to the document, copy its content, and remove it
    document.body.appendChild(tempTextArea);
    tempTextArea.select();
    document.execCommand("copy");
    document.body.removeChild(tempTextArea);

    // Change the button text to "Copied!" temporarily
    const copyButton = document.getElementById(copyButtonId);
    const originalText = copyButton.innerText;
    copyButton.innerText = "Copied!";

    // Disable the button to prevent multiple clicks
    copyButton.disabled = true;

    // Revert the button text back after 1 second
    setTimeout(() => {
        copyButton.innerText = originalText;
        copyButton.disabled = false; // Re-enable the button
    }, 1000);
}

// Usage:
// toggleSidebar(true)  // to collapse
// toggleSidebar(false) // to expand
function toggleSidebar(collapse) {
    // Get elements
    const elements = {
        sidebar: document.getElementById('sidebarMenu'),
        svgicon: document.getElementById('svg-panel-close'),
        navbar: document.getElementById('navbar'),
        main: document.getElementById('main')
    };

    // Check if all elements exist
    if (!Object.values(elements).every(Boolean)) {
        throw new Error('Required elements not found');
    }

    const {sidebar, svgicon, navbar, main} = elements;

    // Toggle classes based on collapse state
    sidebar.classList.toggle('col-md-1', collapse);
    sidebar.classList.toggle('col-lg-1', collapse);
    sidebar.classList.toggle('collapsed', collapse);
    sidebar.classList.toggle('col-md-3', !collapse);
    sidebar.classList.toggle('col-lg-2', !collapse);
    sidebar.classList.toggle('overflow-hidden', collapse);

    navbar.classList.toggle('nonvisible', collapse);
    svgicon.classList.toggle('rotate-180', collapse);

    main.classList.toggle('col-md-12', collapse);
    main.classList.toggle('col-lg-12', collapse);
    main.classList.toggle('expanded', collapse);
    main.classList.toggle('col-md-9', !collapse);
    main.classList.toggle('col-lg-10', !collapse);
}

function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].trim();
        if (cookie.indexOf(nameEQ) === 0) {
            return cookie.substring(nameEQ.length, cookie.length);
        }
    }
    return null;
}

//////////////////////////////////////////
// Listeners
//////////////////////////////////////////
function listenerToggleExampleOfUse() {
    // Toggle Example of use
    const toggleText = document.getElementById('toggleExampleOfUse') || null;
    const toggleIcon = document.getElementById('toggleIcon') || null;
    const collapseElement = document.getElementById('collapseExampleOfUse') || null;

    if (toggleText !== null) {
        collapseElement.addEventListener('shown.bs.collapse', function () {
            toggleIcon.classList.remove('fa-square-plus');
            toggleIcon.classList.add('fa-square-minus');
            toggleText.title = 'Click to collapse';
        });

        collapseElement.addEventListener('hidden.bs.collapse', function () {
            toggleIcon.classList.remove('fa-square-minus');
            toggleIcon.classList.add('fa-square-plus');
            toggleText.title = 'Click to expand';
        });
    }
}

function listenerToggleDataset() {
    // Toggle Dataset
    const toggleTextDataset = document.getElementById('toggleDataset') || null;
    const toggleIconDataset = document.getElementById('toggleIconDataset') || null;
    const collapseElementDataset = document.getElementById('collapseDataset') || null;

    if (collapseElementDataset !== null) {
        collapseElementDataset.addEventListener('shown.bs.collapse', function () {
            toggleIconDataset.classList.remove('fa-square-plus');
            toggleIconDataset.classList.add('fa-square-minus');
            toggleTextDataset.title = 'Click to collapse';
        });

        collapseElementDataset.addEventListener('hidden.bs.collapse', function () {
            toggleIconDataset.classList.remove('fa-square-minus');
            toggleIconDataset.classList.add('fa-square-plus');
            toggleTextDataset.title = 'Click to expand';
        });
    }

    // Toggle Dataset
    const toggleTextTestData = document.getElementById('toggleTestData') || null;
    const toggleIconTestData = document.getElementById('toggleIconTestData') || null;
    const collapseElementTestData = document.getElementById('collapseTestData') || null;

    if (collapseElementTestData !== null) {
        collapseElementTestData.addEventListener('shown.bs.collapse', function () {
            toggleIconTestData.classList.remove('fa-square-plus');
            toggleIconTestData.classList.add('fa-square-minus');
            toggleTextTestData.title = 'Click to collapse';
        });

        collapseElementTestData.addEventListener('hidden.bs.collapse', function () {
            toggleIconTestData.classList.remove('fa-square-minus');
            toggleIconTestData.classList.add('fa-square-plus');
            toggleText.title = 'Click to expand';
        });
    }
}

function listenerToggleSideBar() {
    // JavaScript to toggle sidebar visibility
    const btnPanelClose = document.getElementById('btn-panel-close') || null;
    if (btnPanelClose) {
        btnPanelClose.addEventListener('click', function () {
            if (this.title === "Collapse") {
                this.title = "Expand";
                setCookie("sidebar", "collapsed", 7);
                toggleSidebar(true)
            } else {
                this.title = "Collapse";
                setCookie("sidebar", "expanded", 7);
                toggleSidebar(false)
            }
        });
    }

    // JavaScript to toggle sidebar menu
    const btnToggler = document.getElementById('btn-toggler') || null;
    if (btnToggler) {
        btnToggler.addEventListener('click', function () {
            if (btnPanelClose.title !== "Collapse") {
                this.title = "Collapse";
                setCookie("sidebar", "expanded", 7);
                toggleSidebar(false)
            }
        });
    }
}

function initFullscreen() {
    // Try to find the div - you can update this selector to match your specific div
    // This example uses 'expandable-div' as the ID, but you could change to a class or other selector
    const div = document.getElementById('expandable-div');
    const pre = document.getElementById('expandable-pre-wrap');
    const icon = document.getElementById('expandable-div-icon');

    // If div is not found, try to find it by other means (class, data attribute, etc.)
    // For example: const div = document.querySelector('.your-div-class');

    // Exit if no matching element is found
    if (!div) {
        /// console.warn('Expandable div not found. Make sure the element exists in the DOM.');
        // Try again after a short delay in case the DOM is still loading
        // setTimeout(initFullscreen, 500);
        return;
    }

    // Create a flag to track state
    let isExpanded = false;

    // Store original styles before making any changes
    const originalStyles = {
        border: div.style.border || getComputedStyle(div).border,
        width: div.style.width || getComputedStyle(div).width,
        height: div.style.height || getComputedStyle(div).height,
        position: div.style.position || getComputedStyle(div).position,
        top: div.style.top || getComputedStyle(div).top,
        left: div.style.left || getComputedStyle(div).left,
        zIndex: div.style.zIndex || getComputedStyle(div).zIndex,
        margin: div.style.margin || getComputedStyle(div).margin,
        overflow: div.style.overflow || getComputedStyle(div).overflow
    };

    const preOriginalStyles = {
        height: pre ? (pre.style.height || getComputedStyle(pre).height) : '100%'
    };

    // Add click event listener
    if (icon) {
        icon.addEventListener('click', function (e) {
            // Prevent event bubbling
            e.stopPropagation();

            if (!isExpanded) {
                // Save the current scroll position
                const scrollX = window.scrollX;
                const scrollY = window.scrollY;

                document.body.style.overflow = 'hidden';

                // Expand to fullscreen
                div.style.position = 'fixed';
                div.style.border = '1px solid #cccc';
                div.style.top = '0';
                div.style.left = '0';
                div.style.width = '100%';
                div.style.height = '100%';
                div.style.zIndex = '9999';
                div.style.margin = '0';
                div.style.overflow = 'auto';
                if (pre) {
                    pre.style.height = '100%';
                }

                // Restore scroll position
                window.scrollTo(scrollX, scrollY);

                isExpanded = true;

                // Change icon from expand to compress
                icon.classList.remove('fa-expand');
                icon.classList.add('fa-compress');
                icon.classList.add('expanded');
                icon.title = 'Collapse';

            } else {
                document.body.style.overflow = 'auto';

                // Restore original size and position
                div.style.border = originalStyles.border;
                div.style.width = originalStyles.width;
                div.style.height = originalStyles.height;
                div.style.position = originalStyles.position;
                div.style.top = originalStyles.top;
                div.style.left = originalStyles.left;
                div.style.zIndex = originalStyles.zIndex;
                div.style.margin = originalStyles.margin;
                div.style.overflow = originalStyles.overflow;
                if (pre) {
                    pre.style.height = preOriginalStyles.height;
                }

                isExpanded = false;

                // Change icon from compress to expand
                icon.classList.remove('fa-compress');
                icon.classList.add('fa-expand');
                icon.classList.remove('expanded');
                icon.title = 'Open in Full Screen';
            }
        });
    }

    // Add escape key listener to exit fullscreen mode
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && isExpanded) {
            document.body.style.overflow = 'auto';

            // Restore original size
            div.style.border = originalStyles.border;
            div.style.width = originalStyles.width;
            div.style.height = originalStyles.height;
            div.style.position = originalStyles.position;
            div.style.top = originalStyles.top;
            div.style.left = originalStyles.left;
            div.style.zIndex = originalStyles.zIndex;
            div.style.margin = originalStyles.margin;
            div.style.overflow = originalStyles.overflow;
            if (pre) {
                pre.style.height = preOriginalStyles.height;
            }

            isExpanded = false;

            // Change icon from compress to expand
            icon.classList.remove('fa-compress');
            icon.classList.add('fa-expand');
            icon.classList.remove('expanded');
            icon.title = 'Open in Full Screen';
        }
    });
}


document.addEventListener('DOMContentLoaded', function () {
    listenerToggleExampleOfUse();
    listenerToggleDataset();
    listenerToggleSideBar();
    initFullscreen();
});




