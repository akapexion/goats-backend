const farmersByMarket = {
  "green-valley": {
    name: "Green Valley Market",
    area: "Gulshan",
    description: "Meet the farmers and local shops selling fresh produce at Green Valley Market.",
    farmers: [
      {shop:"Green Valley Organics", name:"Ahmed Khan", rating:"4.9", image:"/images/1.jpg", location:"Gulshan, Karachi", map:"https://www.google.com/maps/search/?api=1&query=Green+Valley+Organics+Gulshan+Karachi"},
      {shop:"Ali Organic Farm", name:"Ali Raza", rating:"4.8", image:"/images/2.jpg", location:"Gulshan-e-Iqbal, Karachi", map:"https://www.google.com/maps/search/?api=1&query=Ali+Organic+Farm+Gulshan+Karachi"},
      {shop:"Fresh Roots Produce", name:"Usman Farooq", rating:"4.7", image:"/images/3.jpg", location:"Gulshan, Karachi", map:"https://www.google.com/maps/search/?api=1&query=Fresh+Roots+Produce+Gulshan+Karachi"}
    ]
  },
  "city-farmers": {
    name: "City Farmers Market",
    area: "Clifton",
    description: "Explore the farmers and local produce shops available at City Farmers Market.",
    farmers: [
      {shop:"Fresh Roots Farm", name:"Bilal Ahmed", rating:"4.9", image:"/images/4.jpg", location:"Clifton, Karachi", map:"https://www.google.com/maps/search/?api=1&query=Fresh+Roots+Farm+Clifton+Karachi"},
      {shop:"Sunny Fields Farm", name:"Hassan Ali", rating:"4.8", image:"/images/5.jpg", location:"Clifton, Karachi", map:"https://www.google.com/maps/search/?api=1&query=Sunny+Fields+Farm+Clifton+Karachi"},
      {shop:"Happy Harvest Farm", name:"Adeel Shah", rating:"4.6", image:"/images/6.jpg", location:"Clifton, Karachi", map:"https://www.google.com/maps/search/?api=1&query=Happy+Harvest+Farm+Clifton+Karachi"}
    ]
  },
  "saturday-fresh": {
    name: "Saturday Fresh Market",
    area: "North Nazimabad",
    description: "Meet the local farmers bringing fresh food to Saturday Fresh Market.",
    farmers: [
      {shop:"Local Harvest Farm", name:"Hamza Malik", rating:"4.8", image:"/images/1.jpg", location:"North Nazimabad, Karachi", map:"https://www.google.com/maps/search/?api=1&query=Local+Harvest+Farm+North+Nazimabad+Karachi"},
      {shop:"Green Roots Farm", name:"Saad Ahmed", rating:"4.7", image:"/images/2.jpg", location:"North Nazimabad, Karachi", map:"https://www.google.com/maps/search/?api=1&query=Green+Roots+Farm+North+Nazimabad+Karachi"},
      {shop:"Pure Fields Organics", name:"Waqas Khan", rating:"4.9", image:"/images/5.jpg", location:"North Nazimabad, Karachi", map:"https://www.google.com/maps/search/?api=1&query=Pure+Fields+Organics+North+Nazimabad+Karachi"}
    ]
  },
  "sunday-local": {
    name: "Sunday Local Market",
    area: "PECHS",
    description: "Discover local farmers and their fresh produce shops at Sunday Local Market.",
    farmers: [
      {shop:"Green Roots Farm", name:"Zain Ahmed", rating:"4.9", image:"images/3.jpg", location:"PECHS, Karachi", map:"https://www.google.com/maps/search/?api=1&query=Green+Roots+Farm+PECHS+Karachi"},
      {shop:"Sunrise Farm Shop", name:"Imran Qureshi", rating:"4.8", image:"images/4.jpg", location:"PECHS, Karachi", map:"https://www.google.com/maps/search/?api=1&query=Sunrise+Farm+Shop+PECHS+Karachi"},
      {shop:"Healthy Basket Farm", name:"Rizwan Ali", rating:"4.7", image:"images/6.jpg", location:"PECHS, Karachi", map:"https://www.google.com/maps/search/?api=1&query=Healthy+Basket+Farm+PECHS+Karachi"}
    ]
  }
};

function stars(rating){
  const full = Math.round(Number(rating));
  return '<i class="fa-solid fa-star"></i>'.repeat(full);
}

const params = new URLSearchParams(window.location.search);
const marketKey = params.get('market') || 'green-valley';
const market = farmersByMarket[marketKey] || farmersByMarket['green-valley'];

document.getElementById('pageTitle').textContent = `${market.name} Farmers`;
document.getElementById('pageDescription').textContent = market.description;
document.getElementById('marketName').textContent = `${market.name} — ${market.area}`;
document.getElementById('farmerCount').textContent = `${market.farmers.length} Farmers`;

document.getElementById('farmerGrid').innerHTML = market.farmers.map(farmer => `
  <article class="farmer-card">
    <div class="farmer-image-wrap">
      <img class="farmer-image" src="${farmer.image}" alt="${farmer.shop}">
      <span class="farmer-badge">Local Farmer</span>
      <a class="map-circle" href="${farmer.map}" target="_blank" rel="noopener" title="Open farmer location">
        <i class="fa-solid fa-location-dot"></i>
      </a>
    </div>
    <div class="farmer-content">
      <h3 class="shop-name">${farmer.shop}</h3>
      <div class="farmer-name"><i class="fa-solid fa-seedling"></i>${farmer.name}</div>
      <div class="rating">${stars(farmer.rating)} <span>(${farmer.rating})</span></div>
      <div class="farmer-location"><i class="fa-solid fa-location-dot"></i><span>${farmer.location}</span></div>
      <a class="location-button" href="${farmer.map}" target="_blank" rel="noopener">
        <i class="fa-solid fa-map-location-dot"></i> View Farmer Location
      </a>
    </div>
  </article>
`).join('');

const menuToggle = document.getElementById('menuToggle');
const navLinks = document.getElementById('navLinks');
const toggleIcon = document.getElementById('toggleIcon');
if(menuToggle){
  menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    toggleIcon.classList.toggle('fa-bars');
    toggleIcon.classList.toggle('fa-xmark');
  });
}
