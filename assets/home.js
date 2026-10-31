/* Sportmall homepage interactions. Product/pricing data is an illustrative catalog. */
(() => {
  'use strict';
  const initialize = () => {
    const grid = document.querySelector('#product-grid');
    if (!grid) return;
    const fa = new Intl.NumberFormat('fa-IR');
    const escape = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[char]));
    const icon = (name, extra = '') => {
      const paths = {
        heart: '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21l8.8-8.6a5.5 5.5 0 0 0 0-7.8Z"/>',
        plus: '<path d="M12 5v14M5 12h14"/>',
        arrow: '<path d="M19 12H5m6-6-6 6 6 6"/>',
        close: '<path d="m6 6 12 12M18 6 6 18"/>',
        check: '<path d="m5 12 4 4L19 6"/>',
        ruler: '<path d="m3 16 13-13 5 5L8 21 3 16Z"/><path d="m12 7 2 2m-6 2 2 2m-6 2 2 2"/>'
      };
      return `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" ${extra}>${paths[name] || paths.arrow}</svg>`;
    };
    const products = [
      {id:'pegasus-41',brand:'NIKE',brandFa:'نایکی',name:'کفش دویدن پگاسوس ۴۱',kind:'دویدن · زنانه و مردانه',category:'shoes',gender:['women','men'],price:6900000,oldPrice:7900000,image:'assets/product-pegasus.jpg',badge:'انتخاب اسپرت‌مال',sizes:['۴۰','۴۱','۴۲','۴۳','۴۴'],colors:['#ededeb','#363637','#c9634b'],description:'یک انتخاب همه‌فن‌حریف برای دویدن‌های روزمره و مسیرهایی که دوست داری کمی طولانی‌تر شوند. فرم راحت و ظاهر پویا، از گرم‌کردن تا آخرین قدم.'},
      {id:'adidas-training',brand:'ADIDAS',brandFa:'آدیداس',name:'تی‌شرت تمرینی آدیداس',kind:'تمرین · مردانه',category:'clothing',gender:['men'],price:1850000,oldPrice:2300000,image:'assets/product-tee.jpg',badge:'تازه‌رسیده',sizes:['S','M','L','XL'],colors:['#282929','#e8e7e3','#6d786a'],description:'یک لایهٔ ساده و کاربردی برای کمد ورزشی تو. برای تمرین روزانه با شلوارک یا گرمکن ترکیبش کن و روی حرکتت تمرکز کن.'},
      {id:'nike-one',brand:'NIKE',brandFa:'نایکی',name:'لگ ورزشی نایکی وان',kind:'یوگا و تمرین · زنانه',category:'clothing',gender:['women'],price:2450000,image:'assets/product-leggings.jpg',badge:'',sizes:['XS','S','M','L'],colors:['#536252','#252628','#a9a39b'],description:'از کشش صبحگاهی تا یک جلسهٔ تمرین پرانرژی؛ فرم ساده و رنگ سبز آرام این لگ، پایه‌ای خوش‌سلیقه برای استایل ورزشی توست.'},
      {id:'nike-brasilia',brand:'NIKE',brandFa:'نایکی',name:'ساک ورزشی نایکی برازیلیا',kind:'اکسسوری · تمرین و سفر',category:'accessories',gender:['women','men'],price:3200000,image:'assets/product-bag.jpg',badge:'',sizes:['تک‌سایز'],colors:['#292b2b','#5a6255'],description:'همراهی جادار برای وسایل روز تمرین. لباس، کفش و وسایل ضروری‌ات را کنار هم داشته باش و سبک‌تر راهی باشگاه شو.'},
      {id:'adidas-response',brand:'ADIDAS',brandFa:'آدیداس',name:'کفش دویدن آدیداس ریسپانس',kind:'دویدن · زنانه و مردانه',category:'shoes',gender:['women','men'],price:5400000,image:'assets/product-adidas-shoe.jpg',badge:'تازه‌رسیده',sizes:['۳۸','۳۹','۴۰','۴۱','۴۲','۴۳'],colors:['#f1f0e9','#262626'],description:'ترکیب سفید و مشکی برای روزهای پرتحرک. مدلی از خانوادهٔ ریسپانس آدیداس که می‌توانی برای مسیرهای روزمره و استایل ورزشی انتخابش کنی.'},
      {id:'nike-park',brand:'NIKE',brandFa:'نایکی',name:'شلوارک ورزشی نایکی پارک',kind:'تمرین و فوتبال · مردانه',category:'clothing',gender:['men'],price:1350000,oldPrice:1800000,image:'assets/product-shorts.jpg',badge:'',sizes:['S','M','L','XL'],colors:['#232323'],description:'یک شلوارک مشکی ساده برای تمرین و فوتبال. فرم آزاد و رنگ خنثی آن با تی‌شرت‌های ورزشی کمدت هماهنگ می‌شود.'},
      {id:'nike-everyday',brand:'NIKE',brandFa:'نایکی',name:'جوراب نایکی اوری‌دی اسنشال',kind:'اکسسوری · روزمره و تمرین',category:'accessories',gender:['women','men'],price:780000,image:'assets/product-socks.jpg',badge:'',sizes:['S','M','L'],colors:['#eee','#292929'],description:'جزئیات کوچک، همراه‌های مهمی هستند. جوراب سفید ساق‌دار برای کامل‌کردن استایل ورزشی روزانه؛ سایز مناسب را پیش از انتخاب بررسی کن.'},
      {id:'nike-bottle',brand:'NIKE',brandFa:'نایکی',name:'قمقمه نایکی بیگ‌ماوث',kind:'اکسسوری · حجم ۹۵۰ میلی‌لیتر',category:'accessories',gender:['women','men'],price:890000,image:'assets/product-bottle.jpg',badge:'',sizes:['تک‌سایز'],colors:['#222'],description:'یک همراه کاربردی برای کنار زمین و داخل ساک تمرین. فرم سادهٔ مشکی با نشان سفید نایکی، مناسب وسایل روز ورزش تو.'},
      {id:'nike-swoosh',brand:'NIKE',brandFa:'نایکی',name:'نیم‌تنه ورزشی نایکی سووش',kind:'استودیو و تمرین · زنانه',category:'clothing',gender:['women'],price:2150000,image:'assets/product-swoosh.png',badge:'',sizes:['XS','S','M','L'],colors:['#f5f4ef','#202420'],description:'فرم سادهٔ سفید با نشان مشکی سووش؛ یک انتخاب هماهنگ با لگ سبز یا مشکی برای کمد ورزشی تو. برای انتخاب میزان حمایت و سایز، مشخصات مدل را بررسی کن.'},
      {id:'nike-miler',brand:'NIKE',brandFa:'نایکی',name:'تی‌شرت دویدن نایکی مایلر',kind:'دویدن و هوازی · مردانه',category:'clothing',gender:['men'],price:2350000,image:'assets/product-miler.png',badge:'تازه‌رسیده',sizes:['S','M','L','XL'],colors:['#8fef5b','#242824'],description:'رنگ سبز پرانرژی برای مسیرهای تازه. این تی‌شرت را کنار شلوارک مشکی و کفش دویدن قرار بده و ترکیب ورزشی خودت را کامل کن.'}
    ];
    let favorites = new Set();
    try {
      const saved = JSON.parse(localStorage.getItem('sportmall-favorites-v1') || '[]');
      if (Array.isArray(saved)) favorites = new Set(saved.filter(id => products.some(product => product.id === id)));
    } catch {}
    let activeFilter = 'all';
    let visibleCount = 4;
    let toastTimer;
    const filterNames = {all:'همهٔ محصولات',shoes:'کفش',clothing:'پوشاک',accessories:'اکسسوری',women:'زنانه',men:'مردانه',favorites:'علاقه‌مندی‌ها',nike:'نایکی',adidas:'آدیداس',sale:'پیشنهادهای ویژه',running:'دویدن',training:'تمرین',yoga:'یوگا',tops:'تی‌شرت و تاپ',leggings:'لگ و شلوار',shorts:'شلوارک',bags:'ساک ورزشی',socks:'جوراب ورزشی',bottles:'قمقمه'};
    const brandNames = {puma:'پوما',reebok:'ریباک',asics:'آسیکس',newbalance:'نیو بالانس',underarmour:'آندر آرمور',skechers:'اسکچرز'};
    const toast = text => {
      const target = document.querySelector('#toast');
      if (!target) return;
      clearTimeout(toastTimer);
      target.textContent = text;
      target.setAttribute('role','status');
      target.classList.add('is-visible');
      target.hidden = false;
      toastTimer = setTimeout(() => { target.classList.remove('is-visible'); target.hidden = true; }, 3400);
    };
    const matchesFilter = product => {
      if (activeFilter === 'tops') return ['adidas-training','nike-swoosh','nike-miler'].includes(product.id);
      const specific = {leggings:'nike-one',shorts:'nike-park',bags:'nike-brasilia',socks:'nike-everyday',bottles:'nike-bottle'};
      if (specific[activeFilter]) return product.id === specific[activeFilter];
      if (activeFilter === 'favorites') return favorites.has(product.id);
      if (activeFilter === 'women' || activeFilter === 'men') return product.gender.includes(activeFilter);
      if (activeFilter === 'nike' || activeFilter === 'adidas') return product.brand.toLowerCase() === activeFilter;
      if (activeFilter.startsWith('brand-')) return product.brand.toLowerCase().replace(/\s+/g,'') === activeFilter.slice(6);
      if (activeFilter === 'sale') return !!product.oldPrice;
      if (activeFilter === 'running') return product.category === 'shoes' || product.id === 'nike-miler';
      if (activeFilter === 'training') return product.category === 'clothing' || product.category === 'accessories';
      if (activeFilter === 'yoga') return ['nike-one','nike-swoosh'].includes(product.id);
      return activeFilter === 'all' || product.category === activeFilter;
    };
    const renderCard = product => `<article class="product-card" data-product-id="${product.id}">
      <div class="product-visual">
        ${product.badge ? `<span class="product-badge">${escape(product.badge)}</span>` : ''}
        <button class="favorite-button${favorites.has(product.id) ? ' is-active' : ''}" type="button" data-favorite="${product.id}" aria-pressed="${favorites.has(product.id)}" aria-label="${favorites.has(product.id) ? 'حذف از' : 'افزودن به'} علاقه‌مندی‌ها: ${escape(product.name)}">${icon('heart')}</button>
        <button class="product-open" type="button" data-product="${product.id}" aria-label="مشاهده ${escape(product.name)}"><img src="${product.image}" alt="${escape(product.name)}" loading="lazy" width="640" height="640"></button>
        <button class="quick-add" type="button" data-product="${product.id}" aria-label="انتخاب سایز و افزودن ${escape(product.name)}">${icon('plus')}<span>انتخاب و خرید</span></button>
      </div>
      <div class="product-info"><div class="product-brand" lang="en" dir="ltr">${product.brand}</div>
        <h3 class="product-name"><button type="button" data-product="${product.id}">${escape(product.name)}</button></h3>
        <p class="product-kind">${escape(product.kind)}</p>
        <div class="product-bottom"><div class="product-price">${product.oldPrice ? `<del class="old-price">${fa.format(product.oldPrice)}</del>` : ''}<span><strong>${fa.format(product.price)}</strong> <small>تومان</small></span></div>
          <div class="product-colors" aria-label="رنگ‌های پیشنهادی استایل">${product.colors.map(color => `<span style="background-color:${color}" aria-hidden="true"></span>`).join('')}</div></div>
      </div></article>`;
    const renderProducts = () => {
      const filtered = products.filter(matchesFilter);
      const emptyCopy = activeFilter === 'favorites' ? ['هنوز انتخابی اینجا نیست','با لمس قلب روی محصولات، علاقه‌مندی‌هایت را کنار هم نگه دار.'] : activeFilter.startsWith('brand-') ? ['در این پیش‌نمایش محصولی از این برند نداریم','می‌توانی انتخاب‌های موجود از برندهای دیگر را ببینی.'] : ['برای این انتخاب محصولی نداریم','دسته‌بندی دیگری را امتحان کن یا همهٔ محصولات را ببین.'];
      grid.innerHTML = filtered.length ? filtered.slice(0,visibleCount).map(renderCard).join('') : `<div class="products-empty"><h3>${emptyCopy[0]}</h3><p>${emptyCopy[1]}</p><button type="button" data-reset-products>مشاهده همهٔ محصولات</button></div>`;
      const count = document.querySelector('#product-count');
      if (count) count.textContent = `${fa.format(filtered.length)} محصول`;
      const status = document.querySelector('#filter-status');
      if (status) { status.textContent = activeFilter === 'all' ? '' : filterNames[activeFilter] || brandNames[activeFilter.slice(6)] || 'برند انتخاب‌شده'; status.hidden = activeFilter === 'all'; }
      const reset = document.querySelector('#clear-filters');
      if (reset) reset.hidden = activeFilter === 'all';
      const more = document.querySelector('#load-more');
      if (more) more.hidden = visibleCount >= filtered.length;
      document.querySelectorAll('.product-tab[data-filter]').forEach(tab => {
        const selected = tab.dataset.filter === activeFilter;
        tab.classList.toggle('is-active',selected);
        if (tab.getAttribute('role') === 'tab') tab.setAttribute('aria-selected',String(selected));
        if (tab.getAttribute('role') !== 'tab') tab.setAttribute('aria-pressed',String(selected));
      });
      const wishlist = document.querySelector('#wishlist-button');
      if (wishlist) wishlist.setAttribute('aria-label',`علاقه‌مندی‌ها، ${fa.format(favorites.size)} محصول`);
    };
    const closeMobileNav = () => {
      const header = document.querySelector('.site-header');
      if (header?.classList.contains('is-open')) header.querySelector('.mobile-menu')?.click();
    };
    const filter = (key = 'all', scroll = true) => {
      activeFilter = Object.hasOwn(filterNames,key) || /^brand-[a-z0-9-]+$/.test(key) ? key : 'all';
      visibleCount = 4;
      renderProducts();
      if (scroll) {
        closeMobileNav();
        const section = document.querySelector('#products');
        section?.setAttribute('tabindex','-1');
        section?.focus({preventScroll:true});
        section?.scrollIntoView({behavior:matchMedia('(prefers-reduced-motion: reduce)').matches?'instant':'smooth',block:'start'});
      }
    };
    window.sportmallHome = {filter};
    const productDialog = document.querySelector('#product-dialog');
    let selectedProduct = null;
    let selectedSize = '';
    const dialogOpeners = new WeakMap();
    const syncDialogLock = () => document.body.classList.toggle('home-dialog-open',!!document.querySelector('#product-dialog[open],#article-dialog[open],#info-dialog[open],#outfit-dialog[open],#story-dialog[open]'));
    const showHomeDialog = (dialog, opener) => {
      closeMobileNav();
      let returnTarget = opener;
      if (opener?.closest('#search-panel')) returnTarget = document.querySelector('.header-actions a[href="#search"]');
      else if (opener?.closest('.main-nav') && matchMedia('(max-width: 980px)').matches) returnTarget = document.querySelector('.mobile-menu');
      dialogOpeners.set(dialog,returnTarget);
      if (!dialog.open) dialog.showModal();
      syncDialogLock();
    };
    const closeDialog = dialog => { if (dialog?.open) dialog.close(); };
    const closeSearch = () => { if (document.querySelector('#search-panel')?.open) document.querySelector('.search-close')?.click(); };
    const openProduct = id => {
      const product = products.find(item => item.id === id);
      if (!product || !productDialog) return;
      const opener = document.activeElement;
      closeSearch();
      selectedProduct = product;
      selectedSize = '';
      productDialog.setAttribute('aria-labelledby','product-dialog-title');
      productDialog.innerHTML = `<button class="dialog-close" type="button" data-close-dialog aria-label="بستن جزئیات محصول" autofocus>${icon('close')}</button>
        <div class="product-modal-layout"><div class="product-modal-image"><img src="${product.image}" alt="${escape(product.name)}" width="640" height="640"></div>
        <div class="product-modal-details"><p class="detail-eyebrow" lang="en" dir="ltr">${product.brand}</p><h2 class="detail-title" id="product-dialog-title">${escape(product.name)}</h2><p class="product-kind">${escape(product.kind)}</p><p class="detail-description">${escape(product.description)}</p>
        <div class="detail-price">${product.oldPrice ? `<del class="old-price">${fa.format(product.oldPrice)}</del> ` : ''}<strong>${fa.format(product.price)}</strong> <span>تومان</span></div>
        <fieldset><legend class="size-label">${product.sizes[0] === 'تک‌سایز' ? 'انتخاب مدل' : 'سایزت را انتخاب کن'}</legend><div class="size-options">${product.sizes.map(size => `<button type="button" class="size-option" data-size="${escape(size)}" aria-pressed="false">${escape(size)}</button>`).join('')}</div></fieldset>
        <details class="size-guide"><summary>${icon('ruler')}راهنمای انتخاب سایز</summary><p>${product.category === 'shoes' ? 'طول پای خود را روی کاغذ اندازه بگیر و با جدول رسمی همین مدل مقایسه کن. سایز کفش بین برندها متفاوت است؛ برای دویدن، فضای آزاد جلوی انگشت‌ها را هم در نظر بگیر.' : product.category === 'accessories' ? 'این محصول در کاتالوگ نمونه با گزینه‌های بالا نمایش داده می‌شود. ابعاد نهایی باید پیش از خرید در مشخصات محصول بررسی شود.' : 'دور سینه، کمر و باسن را بدون سفت‌کردن متر اندازه بگیر و با جدول رسمی همین مدل مقایسه کن. حروف سایز به‌تنهایی معیار دقیق اندازه نیستند.'}</p></details>
        <p class="detail-message" role="status" aria-live="polite"></p><button class="detail-add" type="button" data-add-product>${icon('plus')}افزودن به سبد خرید</button><p class="detail-demo-note">محصول و قیمت نمونه‌اند؛ این پیش‌نمایش سفارش واقعی ثبت نمی‌کند.</p></div></div>`;
      showHomeDialog(productDialog,opener);
    };
    productDialog?.addEventListener('click',event => {
      const size = event.target.closest('[data-size]');
      if (size) {
        selectedSize = size.dataset.size;
        productDialog.querySelectorAll('[data-size]').forEach(option => option.setAttribute('aria-pressed',String(option === size)));
        productDialog.querySelector('.detail-message').textContent = '';
      }
      if (event.target.closest('[data-add-product]')) {
        if (!selectedSize) { productDialog.querySelector('.detail-message').textContent = 'لطفاً ابتدا سایز یا مدل را انتخاب کن.'; productDialog.querySelector('[data-size]')?.focus(); return; }
        if (!window.sportmallCart?.add || !selectedProduct) { toast('سبد خرید آماده نیست؛ صفحه را دوباره باز کن.'); return; }
        closeDialog(productDialog);
        window.sportmallCart.add({...selectedProduct,variant:selectedProduct.sizes[0] === 'تک‌سایز'?selectedSize:`سایز ${selectedSize}`,quantity:1});
      }
    });
    const normalize = value => String(value).toLowerCase().replace(/ي/g,'ی').replace(/ك/g,'ک').replace(/[\u200c\u200d]/g,' ').replace(/\s+/g,' ').trim();
    const resultBox = document.querySelector('#search-results');
    window.sportmallSearch = query => {
      const clear = document.querySelector('.search-clear');
      if (clear) clear.hidden = !query;
      const words = normalize(query).split(' ').filter(Boolean);
      const results = words.length ? products.filter(product => words.every(word => normalize(`${product.name} ${product.brand} ${product.brandFa} ${product.kind} ${product.category}`).includes(word))) : products.slice(0,4);
      if (resultBox) resultBox.innerHTML = results.length ? results.map(product => `<button type="button" class="search-result" data-product="${product.id}"><img class="search-result-image" src="${product.image}" alt="" width="64" height="64"><span class="search-result-copy"><strong>${escape(product.name)}</strong><small>${escape(product.kind)}</small></span><span class="search-result-price">${fa.format(product.price)} <small>تومان</small></span>${icon('arrow')}</button>`).join('') : '<p class="search-empty">چیزی پیدا نشد. «نایکی»، «کفش»، «لگ» یا «آدیداس» را امتحان کن.</p>';
      const status = document.querySelector('.search-status');
      if (status) status.textContent = words.length ? `${fa.format(results.length)} نتیجه برای «${query.trim()}»` : 'پیشنهادهای اسپرت‌مال';
    };
    document.querySelector('.search-input')?.addEventListener('input',event => window.sportmallSearch(event.target.value));
    document.querySelector('.search-clear')?.addEventListener('click', () => { const input = document.querySelector('.search-input'); input.value = ''; window.sportmallSearch(''); input.focus(); });
    window.sportmallSearch('');
    const articles = {
      running:{eyebrow:'راهنمای انتخاب / ۰۱',title:'کفش دویدنِ مناسب تو کدام است؟',intro:'انتخاب کفش از شناخت مسیر و حس راحتی شروع می‌شود. پیش از رنگ و ظاهر، به فرم پا، فضای داخل کفش و کاربرد مدل توجه کن.',tips:['مسیرت را مشخص کن: آسفالت، تردمیل یا مسیر خاکی. توضیح کاربرد و نوع زیرهٔ هر مدل را با جایی که قرار است از آن استفاده کنی مقایسه کن.','کفش را با جوراب معمول دویدن امتحان کن. پنجه نباید فشرده باشد و پاشنه باید هنگام راه‌رفتن در جای خود بماند؛ حس فشار را به امید جا بازکردن نادیده نگیر.','فقط به شمارهٔ سایز تکیه نکن. طول پا و جدول رسمی همان مدل را بررسی کن و پیش از خرید آنلاین، شرایط تعویض سایز را بخوان.'],end:'مدل مناسب، مدلی است که با مسیر تو هماهنگ باشد و از همان اولین امتحان حس راحتی بدهد.'},
      layers:{eyebrow:'راهنمای پوشاک / ۰۲',title:'لباس خوب، بخشی از تمرین خوب است.',intro:'یک لباس ورزشی خوب باید با حرکتت همراه شود. جنس پارچه، برش و امکان ترکیب‌کردن با بقیهٔ لباس‌ها، انتخاب را ساده‌تر می‌کنند.',tips:['برچسب ترکیب پارچه و شیوهٔ شست‌وشو را بخوان. میزان کشسانی، ضخامت و حس پارچه را با نوع فعالیت و دمای محیط هماهنگ کن.','هنگام امتحان‌کردن، دست‌ها را بالا ببر و چند حرکت معمول انجام بده. درزها و کمر لباس نباید فشار ناخوشایند ایجاد کنند یا مدام نیاز به تنظیم داشته باشند.','یک ترکیب کاربردی بساز: بالاپوش ساده، شلوارک یا لگ راحت، و یک لایهٔ سبک برای رفت‌وبرگشت. دو رنگ خنثی و یک رنگ دلخواه برای شروع کافی است.'],end:'لباسی را انتخاب کن که هم از پوشیدنش لذت ببری و هم با استفاده و شست‌وشوی روزمره‌ات سازگار باشد.'},
      recovery:{eyebrow:'همراه تمرین / ۰۳',title:'توی ساک ورزشی‌ات چه خبر است؟',intro:'یک ساک مرتب، آماده‌شدن را کوتاه‌تر می‌کند. لازم نیست همه‌چیز را همراه ببری؛ وسایل ضروری برنامهٔ همان روز را از قبل کنار هم بگذار.',tips:['پایه‌ها را آماده کن: لباس تمرین، جوراب، کفش مناسب، قمقمه و یک حولهٔ کوچک. یک لباس اضافه برای مسیر برگشت هم کاربردی است.','کفش و لباس استفاده‌شده را در کیسه‌ای جدا قرار بده. برای کلید، کارت و وسایل کوچک از جیب زیپ‌دار یا یک کیف کوچک استفاده کن.','بعد از برگشت، ساک را خالی و وسایل را مرتب کن. لباس و حولهٔ استفاده‌شده را جدا کن و فهرست کوتاه وسایل جلسهٔ بعد را دوباره بررسی کن.'],end:'قبل از خرید ساک، ابعاد و تعداد محفظه‌ها را با وسایلی که واقعاً همراه می‌بری مقایسه کن.'}
    };
    const articleDialog = document.querySelector('#article-dialog');
    const openArticle = key => {
      const article = articles[key];
      if (!article || !articleDialog) return;
      const opener = document.activeElement;
      articleDialog.setAttribute('aria-labelledby','article-dialog-title');
      articleDialog.innerHTML = `<button class="dialog-close" type="button" data-close-dialog aria-label="بستن مطلب" autofocus>${icon('close')}</button><article class="editorial-dialog-content"><p class="dialog-eyebrow">${article.eyebrow}</p><h2 class="dialog-title" id="article-dialog-title">${article.title}</h2><p class="dialog-copy">${article.intro}</p><ol class="article-tips">${article.tips.map(tip=>`<li>${tip}</li>`).join('')}</ol><p class="dialog-copy">${article.end}</p></article>`;
      showHomeDialog(articleDialog,opener);
    };
    const infoDialog = document.querySelector('#info-dialog');
    const infoContent = {
      account:['حساب کاربری','این نسخه، پیش‌نمایش هوم‌پیج اسپرت‌مال است. ورود، ثبت‌نام و ثبت سفارش واقعی هنوز فعال نیست.','علاقه‌مندی‌ها و سبد خرید نمونه در همین مرورگر نگهداری می‌شوند تا بتوانی تجربهٔ خرید را بررسی کنی.'],
      shipping:['ارسال سفارش','در فروشگاه نهایی، روش، هزینه و زمان ارسال با توجه به آدرس و اقلام سبد خرید پیش از پرداخت نمایش داده می‌شود.','در این پیش‌نمایش، هیچ سفارش یا ارسال واقعی ثبت نمی‌شود.'],
      returns:['تعویض و بازگشت','برای تجربهٔ بهتر، پیش از انتخاب، مدل و راهنمای سایز را بررسی کن.','شرایط نهایی تعویض و بازگشت باید در نسخهٔ عملیاتی فروشگاه منتشر شود. این پیش‌نمایش تعهد خدمات پس از فروش ایجاد نمی‌کند.'],
      authenticity:['انتخاب با خیال راحت','تصاویر، مدل‌ها و قیمت‌های این هوم‌پیج برای نمایش تجربهٔ فروشگاه انتخاب شده‌اند.','اصالت، موجودی و مشخصات هر کالا باید در فروشگاه عملیاتی توسط فروشنده تأیید شود.'],
      support:['همراه انتخاب تو','برای بررسی این پیش‌نمایش، دسته‌بندی‌ها را امتحان کن، محصولات را جستجو کن و انتخاب‌هایت را در سبد خرید نگه دار.','راه‌های تماس و پشتیبانی فروشگاه در نسخهٔ نهایی اضافه خواهند شد.'],
      about:['اسپرت‌مال؛ برای زندگی در حرکت','ایدهٔ اسپرت‌مال ساده است: انتخاب‌های خوش‌ساخت برای هر شکلی از حرکت؛ از اولین قدم‌های صبح تا آخرین ست تمرین.','این صفحه پیش‌نمایش طراحی فروشگاه است و خرید واقعی در آن انجام نمی‌شود.'],
      privacy:['حریم خصوصی در این پیش‌نمایش','سبد خرید، علاقه‌مندی‌ها و درخواست نمونهٔ خبرنامه فقط در حافظهٔ همین مرورگر ذخیره می‌شوند. هیچ اطلاعاتی از این فرم‌ها برای ما ارسال نمی‌شود.','با پاک‌کردن داده‌های سایت در مرورگر می‌توانی این اطلاعات محلی را حذف کنی.'],
      terms:['راهنمای این پیش‌نمایش','این صفحه برای بررسی طراحی و تعاملات فروشگاه ساخته شده است. قیمت‌ها نمونه‌اند و نمایش کالا به معنی تأیید موجودی نیست.','هیچ پرداخت، ثبت سفارش یا عضویت واقعی از طریق این صفحه انجام نمی‌شود.'],
      discount:['کد خوش‌آمدگویی SPORT20','کد SPORT20 و پیشنهاد ۲۰٪ تخفیف، بخشی از طراحی نمونهٔ فروشگاه هستند. می‌توانی کد را کپی کنی و تجربهٔ صفحه را بررسی کنی.','در این پیش‌نمایش کد روی سبد خرید اعمال نمی‌شود و سفارش واقعی ثبت نمی‌شود. شرایط استفاده و کالاهای مشمول باید در نسخهٔ عملیاتی فروشگاه مشخص شوند.'],
      size:['راهنمای انتخاب سایز','در کارت هر محصول، «انتخاب و خرید» را بزن تا سایزهای نمونه و نکته‌های راهنمای انتخاب را ببینی.','پیش از خرید واقعی، اندازه‌های خود را با جدول رسمی همان برند و همان مدل مقایسه کن.']
    };
    const infoAliases = {delivery:'shipping',return:'returns',guarantee:'authenticity',original:'authenticity',contact:'support',help:'support',faq:'support',payment:'terms',guide:'size',sizing:'size',sizes:'size',promo:'discount'};
    const openInfo = key => {
      if (!infoDialog) return;
      const opener = document.activeElement;
      const info = infoContent[infoAliases[key] || key] || infoContent.about;
      closeSearch();
      infoDialog.setAttribute('aria-labelledby','info-dialog-title');
      infoDialog.innerHTML = `<button class="dialog-close" type="button" data-close-dialog aria-label="بستن" autofocus>${icon('close')}</button><div class="editorial-dialog-content"><p class="dialog-eyebrow">اسپرت‌مال / راهنما</p><h2 class="dialog-title" id="info-dialog-title">${info[0]}</h2><p class="dialog-copy">${info[1]}</p><p class="dialog-copy">${info[2]}</p></div>`;
      showHomeDialog(infoDialog,opener);
    };
    [productDialog,articleDialog,infoDialog].filter(Boolean).forEach(dialog => {
      dialog.addEventListener('toggle',syncDialogLock);
      dialog.addEventListener('close',() => {
        syncDialogLock();
        if (document.querySelector('dialog[open]')) return;
        const opener = dialogOpeners.get(dialog);
        if (opener?.isConnected && opener.getClientRects().length) opener.focus({preventScroll:true});
      });
      dialog.addEventListener('click',event => {
        if (event.target.closest('[data-close-dialog]')) { closeDialog(dialog); return; }
        if (event.target !== dialog) return;
        const rect = dialog.getBoundingClientRect();
        if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) closeDialog(dialog);
      });
    });
    document.addEventListener('click',event => {
      const favorite = event.target.closest('[data-favorite]');
      if (favorite) {
        const id = favorite.dataset.favorite;
        const added = !favorites.has(id);
        if (added) favorites.add(id); else favorites.delete(id);
        try { localStorage.setItem('sportmall-favorites-v1',JSON.stringify([...favorites])); } catch {}
        renderProducts();
        document.querySelectorAll(`[data-favorite="${id}"]`).forEach(button => { button.setAttribute('aria-pressed',String(added)); button.setAttribute('aria-label',`${added?'حذف از':'افزودن به'} علاقه‌مندی‌ها: ${products.find(p => p.id === id).name}`); });
        if (favorite.isConnected) favorite.focus({preventScroll:true}); else document.querySelector(`[data-favorite="${id}"]`)?.focus({preventScroll:true});
        toast(added?'به علاقه‌مندی‌ها اضافه شد.':'از علاقه‌مندی‌ها حذف شد.');
        return;
      }
      const product = event.target.closest('[data-product]');
      if (product) { event.preventDefault(); openProduct(product.dataset.product); return; }
      const tab = event.target.closest('.product-tab[data-filter]');
      if (tab) { filter(tab.dataset.filter,false); return; }
      if (event.target.closest('#clear-filters,[data-reset-products]')) { filter('all',false); return; }
      if (event.target.closest('#load-more')) { const oldCount = visibleCount; visibleCount = products.length; renderProducts(); grid.querySelectorAll('.product-open')[oldCount]?.focus({preventScroll:true}); return; }
      if (event.target.closest('#wishlist-button')) { event.preventDefault(); filter('favorites'); return; }
      const shop = event.target.closest('.shop-link[data-shop]');
      if (shop) { event.preventDefault(); filter(shop.dataset.shop); return; }
      const article = event.target.closest('[data-article]');
      if (article) { event.preventDefault(); openArticle(article.dataset.article); return; }
      const info = event.target.closest('[data-info]');
      if (info) { event.preventDefault(); openInfo(info.dataset.info); return; }
      const link = event.target.closest('a[href^="#"]');
      if (!link) return;
      const target = link.getAttribute('href').slice(1);
      if (link.textContent.trim() === 'ست‌های ورزشی') { event.preventDefault(); closeMobileNav(); document.querySelector('#outfits')?.scrollIntoView({behavior:'smooth'}); return; }
      if (target === 'account') { event.preventDefault(); openInfo('account'); return; }
      if (link.classList.contains('nav-link--mega') && matchMedia('(max-width: 980px)').matches) return;
      if (/^(women|men|shoes|accessories)(?:-|$)/.test(target)) { event.preventDefault(); filter(target.split('-')[0]); }
      else if (target.startsWith('brand-')) {
        event.preventDefault();
        const brand = target.slice(6);
        if (brand === 'nike' || brand === 'adidas') filter(brand);
        else filter(`brand-${brand}`);
      } else if (target === 'new') { event.preventDefault(); filter('all'); }
      else if (target === 'all-brands') { event.preventDefault(); document.querySelector('#brands')?.scrollIntoView({behavior:'smooth'}); }
    });
    document.querySelector('#newsletter-form')?.addEventListener('submit',event => {
      event.preventDefault();
      const input = document.querySelector('#newsletter-email');
      const status = document.querySelector('#newsletter-status');
      if (!input || !status) return;
      if (!input.checkValidity() || !input.value.trim()) { input.reportValidity(); return; }
      try { localStorage.setItem('sportmall-newsletter-preview',input.value.trim()); status.textContent = 'درخواست نمونه در همین مرورگر ذخیره شد؛ عضویت واقعی انجام نشده و ایمیلی ارسال نمی‌شود.'; }
      catch { status.textContent = 'فرم نمونه بررسی شد؛ عضویت واقعی انجام نشده و اطلاعاتی ارسال نمی‌شود.'; }
      input.value = '';
    });
    document.querySelector('#promo-code')?.addEventListener('click',async event => {
      event.preventDefault();
      let copied = false;
      try { await navigator.clipboard.writeText('SPORT20'); copied = true; } catch {
        const input = document.createElement('textarea');
        input.value = 'SPORT20'; input.setAttribute('readonly',''); input.style.cssText = 'position:fixed;left:-9999px;top:0'; document.body.appendChild(input); input.select();
        try { copied = document.execCommand('copy'); } catch {}
        input.remove();
        document.querySelector('#promo-code')?.focus({preventScroll:true});
      }
      toast(copied?'کد SPORT20 کپی شد.':'کد تخفیف نمونه: SPORT20');
    });
    renderProducts();
    Object.assign(window.sportmallHome,{products,openProduct,renderCard,icon,fa,escape,toast});
  };
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded',initialize,{once:true});
  else initialize();
})();
