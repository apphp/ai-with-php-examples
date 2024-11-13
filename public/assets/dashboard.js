var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
});

function copyToClipboard() {
  // Find the <pre> tag content
  const codeContent = document.getElementById("code").innerText;

  // Create a temporary textarea element to hold the content
  const tempTextArea = document.createElement("textarea");
  tempTextArea.value = codeContent;

  // Append the textarea to the document, copy its content, and remove it
  document.body.appendChild(tempTextArea);
  tempTextArea.select();
  document.execCommand("copy");
  document.body.removeChild(tempTextArea);

  // Change the button text to "Copied!" temporarily
  const copyButton = document.getElementById("copyButton");
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

document.addEventListener('DOMContentLoaded', function () {
  const toggleText = document.getElementById('toggleExampleOfUse') || null;
  const toggleIcon = document.getElementById('toggleIconExampleOfUse') || null;
  const collapseElement = document.getElementById('collapseExampleOfUse') || null;

  if (collapseElement !== null) {
    collapseElement.addEventListener('shown.bs.collapse', function () {
      toggleIcon.classList.remove('fa-square-plus');
      toggleIcon.classList.add('fa-square-minus');
      toggleText.title = 'Click to collapse';
    });
  }

  if (collapseElement !== null) {
    collapseElement.addEventListener('hidden.bs.collapse', function () {
      toggleIcon.classList.remove('fa-square-minus');
      toggleIcon.classList.add('fa-square-plus');
      toggleText.title = 'Click to expand';
    });
  }

  const toggleTextDataset = document.getElementById('toggleDataset') || null;
  const toggleIconDataset = document.getElementById('toggleIconDataset') || null;
  const collapseElementDataset = document.getElementById('collapseDataset') || null;

  if (collapseElementDataset !== null) {
    collapseElementDataset.addEventListener('shown.bs.collapse', function () {
      toggleIconDataset.classList.remove('fa-square-plus');
      toggleIconDataset.classList.add('fa-square-minus');
      toggleTextDataset.title = 'Click to collapse';
    });
  }

  if (collapseElementDataset !== null) {
    collapseElementDataset.addEventListener('hidden.bs.collapse', function () {
      toggleIconDataset.classList.remove('fa-square-minus');
      toggleIconDataset.classList.add('fa-square-plus');
      toggleText.title = 'Click to expand';
    });
  }
});

// JavaScript to toggle sidebar visibility
document.getElementById('btn-panel-close').addEventListener('click', function() {
  const sidebar = document.getElementById('sidebarMenu');
  const icon = document.getElementById('btn-panel-close-icon');
  const nav = document.getElementById('navbar');
  const main = document.getElementById('main');

  // Toggle sidebar classes
  ['col-md-3', 'col-lg-2', 'col-md-1', 'col-lg-1', 'collapsed'].forEach(cls => sidebar.classList.toggle(cls));

  // Toggle icon classes
  ['fa-chevron-left', 'fa-chevron-right'].forEach(cls => icon.classList.toggle(cls));

  // Toggle navbar visibility
  nav.classList.toggle('nonvisible');

  // Toggle main content classes
  ['col-md-9', 'col-lg-10', 'col-md-12', 'col-lg-12', 'expanded'].forEach(cls => main.classList.toggle(cls));
});
