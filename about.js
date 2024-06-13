const accordionItems = document.querySelectorAll('.AboutUs .accordion-item');
 
accordionItems.forEach(item => {
  const header = item.querySelector('.accordion-header');
  const content = item.querySelector('.accordion-content');
 
  header.addEventListener('click', function() {
    content.classList.toggle('active');
    header.classList.toggle('active');
  });
});
 