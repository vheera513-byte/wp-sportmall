/* Desktop editorial extensions: daily edit, complete looks and sample customer stories. */
(() => {
  'use strict';
  const initialize = () => {
    const home = window.sportmallHome;
    if (!home?.products) return;
    const {products,renderCard,icon,fa,escape,openProduct} = home;
    const productById = id => products.find(product => product.id === id);
    const arrow = '<svg class="icon" aria-hidden="true"><use href="#i-arrow"/></svg>';
    const plus = '<svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>';
    const money = value => fa.format(value);

    const dealProducts = ['pegasus-41','adidas-training','nike-park'].map(productById);
    document.querySelector('#deal-products').innerHTML = dealProducts.map(product => renderCard({...product,badge:`${money(Math.round((1-product.price/product.oldPrice)*100))}٪ تخفیف`})).join('');

    const outfits = [
      {title:'تمرکز روی حرکت.',name:'تمرین روزانه',edition:'01 / THE TRAINING EDIT',description:'مشکی و سفید؛ یک ترکیب بی‌حاشیه برای روزهایی که تمام تمرکزت روی تمرین است.',tags:['۴ آیتم هماهنگ','تمرین و باشگاه'],photo:'assets/category-men.jpg',position:'50% 38%',items:['adidas-training','nike-park','adidas-response','nike-everyday'],labels:['تی‌شرت تمرینی','شلوارک مشکی','کفش ریسپانس','جوراب ساق‌دار']},
      {title:'سبک بپوش.\nرها حرکت کن.',name:'ریتم آرام',edition:'02 / THE STUDIO EDIT',description:'سبز زیتونی در کنار سفید؛ برای کشش صبحگاهی و لحظه‌هایی که به خودت برمی‌گردی.',tags:['۴ آیتم هماهنگ','استودیو و تمرین'],photo:'assets/category-women.jpg',position:'50% 42%',items:['nike-swoosh','nike-one','adidas-response','nike-brasilia'],labels:['نیم‌تنهٔ سفید','لگ سبز زیتونی','کفش سفید','ساک برازیلیا']},
      {title:'یک کیلومتر\nبیشتر.',name:'مسیر تازه',edition:'03 / THE RUNNING EDIT',description:'سبز پرانرژی کنار مشکی؛ یک جفت کفش آمادهٔ حرکت و همراهی کوچک برای مسیرهای بلندتر.',tags:['۴ آیتم هماهنگ','دویدن و هوازی'],photo:'assets/journal-training.jpg',position:'50% 65%',items:['nike-miler','nike-park','pegasus-41','nike-bottle'],labels:['تی‌شرت مایلر','شلوارک سبک','پگاسوس ۴۱','قمقمهٔ همراه']}
    ];
    let activeOutfit = 0;
    const stage = document.querySelector('#outfit-stage');
    const outfitTabs = document.querySelector('#outfit-tabs');
    const outfitTotal = outfit => outfit.items.reduce((sum,id) => sum + productById(id).price,0);
    const renderOutfit = (animate = true) => {
      const outfit = outfits[activeOutfit];
      stage.setAttribute('aria-label',`ست ${money(activeOutfit+1)} از ${money(outfits.length)}: ${outfit.name}`);
      stage.innerHTML = `<div class="outfit-copy"><span class="outfit-edition" lang="en">${outfit.edition}</span><h3>${escape(outfit.title).replace(/\n/g,'<br>')}</h3><p>${outfit.description}</p><div class="outfit-tags">${outfit.tags.map(tag=>`<span>${tag}</span>`).join('')}</div><div class="outfit-total"><span>قیمت مجموع چهار آیتم</span><strong>${money(outfitTotal(outfit))}</strong><small>تومان</small></div><button class="outfit-buy" data-open-outfit>این ست را انتخاب کن ${arrow}</button></div><div class="outfit-look"><img src="${outfit.photo}" alt="الهام تصویری برای استایل ${outfit.name}" style="object-position:${outfit.position}" loading="lazy"><small>LOOK / 0${activeOutfit+1}</small><span>الهام بگیر؛ ترکیب خودت را بساز.</span></div><div class="outfit-board">${outfit.items.map((id,i)=>{const product = productById(id);return `<button class="outfit-piece" data-product="${id}" aria-label="مشاهده ${product.name}"><span class="outfit-piece-num">0${i+1}</span><img src="${product.image}" alt="${product.name}" loading="lazy" width="180" height="160"><span class="outfit-piece-title">${outfit.labels[i]}${plus}</span></button>`;}).join('')}</div>`;
      document.querySelector('#outfit-counter').textContent = `0${activeOutfit+1} / 03`;
      outfitTabs.querySelectorAll('button').forEach((button,index)=>button.setAttribute('aria-pressed',String(index === activeOutfit)));
      if (animate) { stage.classList.remove('is-changing'); void stage.offsetWidth; stage.classList.add('is-changing'); }
    };
    outfitTabs.innerHTML = outfits.map((outfit,i)=>`<button class="outfit-tab" data-outfit-index="${i}" aria-pressed="${i===0}"><span>0${i+1}</span>${outfit.name}</button>`).join('');
    const moveOutfit = delta => { activeOutfit = (activeOutfit+delta+outfits.length)%outfits.length; renderOutfit(); };
    document.querySelector('#outfit-prev').addEventListener('click',()=>moveOutfit(-1));
    document.querySelector('#outfit-next').addEventListener('click',()=>moveOutfit(1));
    outfitTabs.addEventListener('click',event=>{const button = event.target.closest('[data-outfit-index]');if(button){activeOutfit=Number(button.dataset.outfitIndex);renderOutfit();}});
    stage.addEventListener('keydown',event=>{if(event.key==='ArrowLeft'||event.key==='ArrowRight'){event.preventDefault();moveOutfit(event.key==='ArrowLeft'?1:-1);}});
    renderOutfit(false);

    const outfitDialog = document.querySelector('#outfit-dialog');
    const storyDialog = document.querySelector('#story-dialog');
    const openers = new WeakMap();
    const lock = () => document.body.classList.toggle('home-dialog-open',!!document.querySelector('#product-dialog[open],#article-dialog[open],#info-dialog[open],#outfit-dialog[open],#story-dialog[open]'));
    const show = dialog => {openers.set(dialog,document.activeElement);dialog.showModal();lock();};
    [outfitDialog,storyDialog].forEach(dialog=>{
      dialog.addEventListener('close',()=>{lock();if(!document.querySelector('dialog[open]')){const opener=openers.get(dialog);if(opener?.isConnected)opener.focus({preventScroll:true});}});
      dialog.addEventListener('click',event=>{
        if(event.target.closest('[data-editorial-close]'))dialog.close();
        if(event.target===dialog){const rect=dialog.getBoundingClientRect();if(event.clientX<rect.left||event.clientX>rect.right||event.clientY<rect.top||event.clientY>rect.bottom)dialog.close();}
      });
    });
    let bundleOutfit = null;
    const openOutfit = () => {
      bundleOutfit = outfits[activeOutfit];
      outfitDialog.innerHTML = `<button class="dialog-close" data-editorial-close aria-label="بستن انتخاب ست" autofocus>${icon('close')}</button><p class="eyebrow">چهار انتخاب، یک استایل</p><h2 class="dialog-title">ست ${bundleOutfit.name}</h2><p class="outfit-dialog-intro">سایز هر آیتم را جدا انتخاب کن؛ همهٔ آن‌ها با هم به سبدت اضافه می‌شوند.</p><form id="bundle-form" novalidate><div class="outfit-dialog-items">${bundleOutfit.items.map(id=>{const p=productById(id);return `<div class="outfit-dialog-item"><img src="${p.image}" alt="" width="65" height="69"><div><h3>${p.name}</h3><p>${money(p.price)} تومان</p></div><select name="${p.id}" aria-label="سایز ${p.name}" required>${p.sizes.length>1?'<option value="">انتخاب سایز</option>':''}${p.sizes.map(size=>`<option value="${escape(size)}">${size}</option>`).join('')}</select></div>`;}).join('')}</div><div class="bundle-total"><span>جمع این ست</span><div><strong>${money(outfitTotal(bundleOutfit))}</strong> <small>تومان</small></div></div><p class="bundle-message" role="status"></p><button type="submit" class="accent-button bundle-add">افزودن ست به سبد ${plus}</button><p class="detail-demo-note">قیمت‌ها نمونه‌اند؛ ثبت سفارش و پرداخت واقعی انجام نمی‌شود.</p></form>`;
      show(outfitDialog);
    };
    stage.addEventListener('click',event=>{if(event.target.closest('[data-open-outfit]'))openOutfit();});
    outfitDialog.addEventListener('change',event=>{if(event.target.matches('select'))event.target.removeAttribute('aria-invalid');});
    outfitDialog.addEventListener('submit',event=>{
      event.preventDefault();
      const fields = [...outfitDialog.querySelectorAll('select')];
      const missing = fields.filter(field=>!field.value);
      fields.forEach(field=>field.setAttribute('aria-invalid',String(!field.value)));
      if(missing.length){outfitDialog.querySelector('.bundle-message').textContent='لطفاً سایز همهٔ آیتم‌ها را انتخاب کن.';missing[0].focus();return;}
      if(!window.sportmallCart?.add)return;
      const selection = fields.map(field=>({...productById(field.name),variant:field.value==='تک‌سایز'?field.value:`سایز ${field.value}`,quantity:1}));
      outfitDialog.close();
      selection.forEach(item=>window.sportmallCart.add(item));
    });

    const stories = [
      {name:'مریم',initial:'م',activity:'پیلاتس و تمرین',title:'همون راحتی که\nدنبالش بودم.',category:'از انتخاب تا اولین تمرین',photo:'assets/category-women.jpg',position:'50% 32%',quote:'از اون لباس‌هاست که وقتی می‌پوشیش، فقط به حرکت بعدی فکر می‌کنی. راحت، ساده و دقیقاً به سبک خودم.',product:'nike-one'},
      {name:'علی',initial:'ع',activity:'تمرین قدرتی',title:'همهٔ وسایلم،\nیک همراه.',category:'روایت یک همراه همیشگی',photo:'assets/category-men.jpg',position:'50% 35%',quote:'لباس، کفش و وسایل تمرینم بالاخره کنار هم جا شدند. حالا فقط ساکم رو برمی‌دارم و راهی می‌شم.',product:'nike-brasilia'},
      {name:'نگار',initial:'ن',activity:'دویدن و هوازی',title:'شروع خوب،\nبا یک جفت تازه.',category:'حس اولین قدم',photo:'assets/hero-motion.jpg',position:'49% 50%',quote:'اولین مسیر با کفش جدید همیشه یه حس دیگه داره. رنگ و استایلش همون چیزی بود که برای شروع دوباره می‌خواستم.',product:'pegasus-41'},
      {name:'سامان',initial:'س',activity:'زندگی پرتحرک',title:'از باشگاه،\nتا هر جای شهر.',category:'انتخابی برای هر روز',photo:'assets/journal-training.jpg',position:'50% 65%',quote:'یه تی‌شرت ساده که هم برای تمرین انتخابش می‌کنم، هم برای بیرون رفتن. راحت با بقیهٔ لباس‌هام ست می‌شه.',product:'adidas-training'}
    ];
    const person = story => `<span class="story-person"><span class="story-avatar">${story.initial}</span><span>${story.name}<small>${story.activity}</small></span></span>`;
    document.querySelector('#stories-grid').innerHTML = stories.map((story,i)=>`<button class="story-card" data-story="${i}" aria-label="باز کردن استوری نمونهٔ ${story.name}"><img src="${story.photo}" style="object-position:${story.position}" alt="" loading="lazy" width="310" height="390">${person(story)}<div class="story-card-content"><span class="story-category">${story.category}</span><h3>${story.title.replace(/\n/g,'<br>')}</h3><span class="story-card-foot"><span>دیدن داستان</span>${arrow}</span></div></button>`).join('');
    let activeStory = 0;
    const renderStory = () => {
      const story = stories[activeStory];
      const product = productById(story.product);
      storyDialog.innerHTML = `<img class="story-dialog-image" src="${story.photo}" alt="تصویر الهام‌بخش استوری ${story.name}" style="object-position:${story.position}"><div class="story-progress" role="group" aria-label="انتخاب استوری">${stories.map((s,i)=>`<button data-story-index="${i}" aria-label="استوری ${s.name}" aria-current="${activeStory===i}"></button>`).join('')}</div>${person(story)}<button class="dialog-close" data-editorial-close aria-label="بستن استوری" autofocus>${icon('close')}</button><div class="story-content"><span class="story-category">${story.category}</span><span class="story-quote-mark" aria-hidden="true">“</span><blockquote>${story.quote}</blockquote><p class="story-sample">روایت و نام نمایشی · این استوری نمونهٔ طراحی است.</p><button class="story-product" data-story-product="${product.id}"><img src="${product.image}" alt="" width="52" height="57"><span>${product.name}<small>این انتخاب را ببین</small></span>${arrow}</button><div class="story-dialog-controls"><button data-story-step="-1" ${activeStory===0?'disabled':''}>${arrow}داستان قبلی</button><span>${money(activeStory+1)} / ${money(stories.length)}</span><button data-story-step="1" ${activeStory===stories.length-1?'disabled':''}>داستان بعدی${arrow}</button></div></div>`;
    };
    const changeStory = (index, focusSelector) => {activeStory=Math.max(0,Math.min(stories.length-1,index));renderStory();storyDialog.querySelector(focusSelector||'[data-editorial-close]')?.focus({preventScroll:true});};
    document.querySelector('#stories-grid').addEventListener('click',event=>{const button=event.target.closest('[data-story]');if(button){activeStory=Number(button.dataset.story);renderStory();show(storyDialog);}});
    storyDialog.addEventListener('click',event=>{
      const step=event.target.closest('[data-story-step]');
      const index=event.target.closest('[data-story-index]');
      const product=event.target.closest('[data-story-product]');
      if(step){const next=activeStory+Number(step.dataset.storyStep);changeStory(next,`[data-story-index="${next}"]`);}
      if(index)changeStory(Number(index.dataset.storyIndex),`[data-story-index="${index.dataset.storyIndex}"]`);
      if(product){const opener=openers.get(storyDialog);storyDialog.close();opener?.focus({preventScroll:true});openProduct(product.dataset.storyProduct);}
    });
    storyDialog.addEventListener('keydown',event=>{if(event.key==='ArrowLeft'||event.key==='ArrowRight'){event.preventDefault();changeStory(activeStory+(event.key==='ArrowLeft'?1:-1));}});
  };
  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',initialize,{once:true});else initialize();
})();
