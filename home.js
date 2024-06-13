// Smooth scroll for internal links (optional)
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      document.querySelector(this.getAttribute('href')).scrollIntoView({
        behavior: 'smooth'
      });
    });
  });
 
  // Hero section image slider (optional)
  const heroImages = [
    "images/banner-bg1.jpg",
    "images/banner-bg2.jpg",
    "images/banner-bg3.jpg"
  ];
  let currentImageIndex = 0;
 
  function changeHeroImage() {
    const heroImage = document.querySelector('.hero img');
    currentImageIndex = (currentImageIndex + 1) % heroImages.length;
    heroImage.src = heroImages[currentImageIndex];
  }
 
  setInterval(changeHeroImage, 5000); // Change image every 5 seconds
 
  // Product card hover effect (optional)
  const productCards = document.querySelectorAll('.product-card');
 
  productCards.forEach(card => {
    card.addEventListener('mouseover', () => {
      card.classList.add('hovered');
    });
 
    card.addEventListener('mouseout', () => {
      card.classList.remove('hovered');
    });
  });
 
  // Add functionality based on your needs (e.g., social media icons)