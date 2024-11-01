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
