const searchInput=document.getElementById('productSearch');
const searchButton=document.getElementById('searchButton');
const sortSelect=document.getElementById('sortProducts');
const grid=document.getElementById('productGrid');
const empty=document.getElementById('noProducts');
const sideFilters=document.querySelectorAll('.side-filter');
const priceInputs=document.querySelectorAll('input[name="price"]');
const ratingRows=document.querySelectorAll('.rating-row');
const resetButton=document.getElementById('resetFilters');
let category='all';
let minRating=0;
let priceRange='all';

function updateProducts(){
  const query=searchInput.value.trim().toLowerCase();
  const cards=[...grid.querySelectorAll('.product-card')];
  const visible=cards.filter(card=>{
    const name=card.dataset.name.toLowerCase();
    const cardCategory=card.dataset.category;
    const price=parseFloat(card.dataset.price);
    const rating=parseFloat(card.dataset.rating);
    let priceOk=true;
    if(priceRange==='0-5') priceOk=price<=5;
    if(priceRange==='5-10') priceOk=price>5&&price<=10;
    if(priceRange==='10-20') priceOk=price>10&&price<=20;
    if(priceRange==='20') priceOk=price>20;
    return name.includes(query)&&(category==='all'||cardCategory===category)&&priceOk&&rating>=minRating;
  });

  const originalOrder=new Map(cards.map((card,index)=>[card,index]));
  visible.sort((a,b)=>{
    if(sortSelect.value==='price-low') return +a.dataset.price-+b.dataset.price;
    if(sortSelect.value==='price-high') return +b.dataset.price-+a.dataset.price;
    if(sortSelect.value==='name') return a.dataset.name.localeCompare(b.dataset.name);
    return originalOrder.get(a)-originalOrder.get(b);
  });
  cards.forEach(card=>card.style.display='none');
  visible.forEach(card=>{card.style.display='block';grid.appendChild(card)});
  empty.style.display=visible.length?'none':'block';
}

sideFilters.forEach(btn=>btn.addEventListener('click',()=>{
  sideFilters.forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  category=btn.dataset.category;
  updateProducts();
}));
priceInputs.forEach(input=>input.addEventListener('change',()=>{priceRange=input.value;updateProducts()}));
ratingRows.forEach(row=>row.addEventListener('click',()=>{minRating=Number(row.dataset.rating);updateProducts()}));
searchInput.addEventListener('input',updateProducts);
searchButton.addEventListener('click',updateProducts);
sortSelect.addEventListener('change',updateProducts);
document.querySelectorAll('.heart-btn').forEach(btn=>btn.addEventListener('click',()=>btn.classList.toggle('selected')));
resetButton.addEventListener('click',()=>{
  category='all';minRating=0;priceRange='all';searchInput.value='';sortSelect.value='featured';
  sideFilters.forEach(b=>b.classList.toggle('active',b.dataset.category==='all'));
  priceInputs.forEach(i=>i.checked=i.value==='all');
  updateProducts();
});
document.getElementById('menuToggle')?.addEventListener('click',()=>document.getElementById('navLinks')?.classList.toggle('active'));
