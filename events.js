// Get the element where the appreciation braai date will be displayed
const appreciationDateElement = document.getElementById('appreciation-date');

// Function to calculate the next appreciation braai date (replace with your logic)
function getNextAppreciationDate() {
  // Replace this with your logic to calculate the next date based on current date and 6-month interval
  const today = new Date();
  // Add 6 months to the current date (placeholder, adjust as needed)
  today.setMonth(today.getMonth() + 6); 
  
  // Format the date for display (example - adjust formatting as desired)
  const formattedDate = today.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
  
  return formattedDate;
}

// Get the next appreciation braai date and display it
const nextAppreciationDate = getNextAppreciationDate();
appreciationDateElement.textContent == nextAppreciationDate;