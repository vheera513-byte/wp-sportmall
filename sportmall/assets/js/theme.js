/* global SportmallData */
/**
 * Sportmall storefront interactions.
 * Vanilla JS, no build step. All features degrade gracefully.
 */
(function () {
	'use strict';

	const data = window.SportmallData || {};
	const strings = data.strings || {};
	const faDigits = (value) => String(value).replace(/[0-9]/g, (d) => '۰۱۲۳۴۵۶۷۸۹'[Number(d)]);
	const escapeHtml = (value) => String(value == null ? '' : value).replace(/[&<>"']/g, (char) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[char]));
	const nl2br = (value) => escapeHtml(value).replace(/\n/g, '<br>');
	const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	let toastTimer = null;
	function toast(message) {
		const target = document.querySelector('#toast');
		if (!target || !message) return;
		clearTimeout(toastTimer);
		target.textContent = message;
		target.classList.add('is-visible');
		target.hidden = false;
		toastTimer = setTimeout(() => {
			target.classList.remove('is-visible');
			target.hidden = true;
		}, 3400);
	}

	function setBodyLock(className, active) {
		document.body.classList.toggle(className, Boolean(active));
	}

	/* ---------------------------------------------------------------------
	 * Announcement marquee
	 * ------------------------------------------------------------------- */
	function initMarquee() {
		const bar = document.querySelector('.announcement-bar');
		const track = bar?.querySelector('[data-sm-marquee]');
		const group = track?.querySelector('.announcement-group');
		if (!bar || !track || !group) return;

		const base = group.innerHTML;
		let resizeTimer;
		function build() {
			track.querySelectorAll('[data-clone]').forEach((node) => node.remove());
			group.innerHTML = base;
			let guard = 0;
			while (group.offsetWidth < bar.clientWidth && guard++ < 24) {
				group.insertAdjacentHTML('beforeend', base);
			}
			const clone = group.cloneNode(true);
			clone.setAttribute('aria-hidden', 'true');
			clone.setAttribute('data-clone', '');
			track.appendChild(clone);
			track.style.setProperty('--marquee-duration', Math.max(14, group.offsetWidth / 45) + 's');
		}
		build();
		window.addEventListener('resize', () => {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(build, 200);
		});
		if (document.fonts?.ready) document.fonts.ready.then(build);
	}

	/* ---------------------------------------------------------------------
	 * Dialogs (search & cart)
	 * ------------------------------------------------------------------- */
	const openDialogs = new WeakMap();

	function openDialog(dialog, trigger) {
		if (!dialog) return;
		if (dialog.open) return;
		openDialogs.set(dialog, trigger || document.activeElement);
		dialog.setAttribute('aria-hidden', 'false');
		if (typeof dialog.showModal === 'function') {
			dialog.showModal();
		} else {
			dialog.setAttribute('open', '');
		}
		setBodyLock(dialog.classList.contains('cart-panel') ? 'cart-modal-open' : 'search-modal-open', true);
	}

	function closeDialog(dialog) {
		if (!dialog || !dialog.open) return;
		dialog.close();
		dialog.setAttribute('aria-hidden', 'true');
		setBodyLock('search-modal-open', false);
		setBodyLock('cart-modal-open', false);
		const opener = openDialogs.get(dialog);
		if (opener && opener.isConnected) opener.focus({ preventScroll: true });
	}

	function initDialogBasics(dialog) {
		if (!dialog) return;
		dialog.addEventListener('click', (event) => {
			if (event.target.closest('[data-sm-close]')) {
				closeDialog(dialog);
				return;
			}
			if (event.target === dialog) {
				const rect = dialog.getBoundingClientRect();
				if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) {
					closeDialog(dialog);
				}
			}
		});
		dialog.addEventListener('close', () => {
			dialog.setAttribute('aria-hidden', 'true');
			setBodyLock('search-modal-open', false);
			setBodyLock('cart-modal-open', false);
		});
	}

	/* ---------------------------------------------------------------------
	 * Header, mega menu, mobile navigation
	 * ------------------------------------------------------------------- */
	function initHeader() {
		const header = document.querySelector('[data-sm-header]');
		const menuButton = header?.querySelector('[data-sm-menu]');
		const nav = header?.querySelector('.main-nav');
		if (!header) return;

		menuButton?.addEventListener('click', () => {
			const open = header.classList.toggle('is-open');
			menuButton.setAttribute('aria-expanded', String(open));
			document.body.classList.toggle('nav-open', open);
		});

		// Close the mobile drawer when following a link.
		nav?.addEventListener('click', (event) => {
			if (event.target.closest('a') && window.matchMedia('(max-width: 980px)').matches && !event.target.closest('.nav-link--mega')) {
				header.classList.remove('is-open');
				menuButton?.setAttribute('aria-expanded', 'false');
				document.body.classList.remove('nav-open');
			}
		});

		// Mega menu toggling for touch and keyboard users.
		nav?.querySelectorAll('.nav-link--mega').forEach((link) => {
			link.addEventListener('click', (event) => {
				if (window.matchMedia('(min-width: 981px)').matches && !window.matchMedia('(hover: none)').matches) return;
				event.preventDefault();
				const item = link.closest('.nav-item');
				const open = !item.classList.contains('is-open');
				nav.querySelectorAll('.nav-item.is-open').forEach((other) => {
					other.classList.remove('is-open');
					other.querySelector('.nav-link--mega')?.setAttribute('aria-expanded', 'false');
				});
				item.classList.toggle('is-open', open);
				link.setAttribute('aria-expanded', String(open));
			});
			link.addEventListener('mouseenter', () => {
				if (!window.matchMedia('(max-width: 980px)').matches) link.setAttribute('aria-expanded', 'true');
			});
			link.addEventListener('mouseleave', () => {
				if (!link.closest('.nav-item').classList.contains('is-open')) link.setAttribute('aria-expanded', 'false');
			});
		});

		document.addEventListener('click', (event) => {
			if (!nav) return;
			if (!event.target.closest('.nav-item') && !event.target.closest('[data-sm-menu]')) {
				nav.querySelectorAll('.nav-item.is-open').forEach((item) => {
					item.classList.remove('is-open');
					item.querySelector('.nav-link--mega')?.setAttribute('aria-expanded', 'false');
				});
			}
		});

		// Solid header gains a subtle shadow once the page scrolls.
		const solidHeader = document.querySelector('.site-header--solid');
		if (solidHeader) {
			const onScroll = () => solidHeader.classList.toggle('is-scrolled', window.scrollY > 12);
			onScroll();
			window.addEventListener('scroll', onScroll, { passive: true });
		}

		document.querySelectorAll('[data-sm-open]').forEach((trigger) => {
			trigger.addEventListener('click', (event) => {
				const kind = trigger.getAttribute('data-sm-open');
				const dialog = kind === 'cart' ? document.querySelector('#cart-panel') : document.querySelector('#search-panel');
				if (!dialog) return;
				event.preventDefault();
				openDialog(dialog, trigger);
				if (kind === 'search') {
					setTimeout(() => document.querySelector('[data-sm-search-input]')?.focus(), 60);
				}
				if (kind === 'cart' && window.jQuery) {
					window.jQuery(document.body).trigger('wc_fragment_refresh');
				}
			});
		});
	}

	/* ---------------------------------------------------------------------
	 * Hero slider
	 * ------------------------------------------------------------------- */
	function initHero() {
		const hero = document.querySelector('[data-sm-hero]');
		if (!hero) return;
		const slides = Array.from(hero.querySelectorAll('.slide'));
		const dots = Array.from(hero.querySelectorAll('[data-sm-hero-dot]'));
		const title = hero.querySelector('[data-sm-hero-title]');
		const kicker = hero.querySelector('[data-sm-hero-kicker]');
		const description = hero.querySelector('[data-sm-hero-text]');
		const cta = hero.querySelector('[data-sm-hero-cta]');
		const content = hero.querySelector('[data-sm-hero-content]');
		const prev = hero.querySelector('[data-sm-hero-prev]');
		const next = hero.querySelector('[data-sm-hero-next]');
		if (slides.length < 2) return;

		let current = 0;
		let timer = null;
		const autoplay = hero.dataset.autoplay === '1' && !reduceMotion;
		const delay = 6000;

		function restartProgress() {
			dots.forEach((dot, index) => {
				if (index === current) {
					dot.classList.remove('is-active');
					void dot.offsetWidth;
					dot.classList.add('is-active');
					dot.setAttribute('aria-current', 'true');
				} else {
					dot.classList.remove('is-active');
					dot.removeAttribute('aria-current');
				}
			});
		}

		function go(index, animate = true) {
			current = (index + slides.length) % slides.length;
			slides.forEach((slide, i) => slide.classList.toggle('is-active', i === current));
			const slide = slides[current];
			restartProgress();

			const apply = () => {
				if (kicker) kicker.textContent = slide.dataset.kicker || '';
				if (title) title.innerHTML = nl2br(slide.dataset.title || '');
				if (description) description.textContent = slide.dataset.text || '';
				if (cta) {
					const span = cta.querySelector('span');
					if (span) span.textContent = slide.dataset.cta || '';
					cta.setAttribute('href', slide.dataset.url || data.shopUrl || '/');
				}
				content?.classList.remove('is-out');
			};

			if (animate && content) {
				content.classList.add('is-out');
				setTimeout(apply, reduceMotion ? 0 : 280);
			} else {
				apply();
			}
			schedule();
		}

		function schedule() {
			clearTimeout(timer);
			if (!autoplay) return;
			timer = setTimeout(() => go(current + 1), delay);
		}
		function pause() {
			clearTimeout(timer);
			hero.classList.add('is-paused');
		}
		function resume() {
			hero.classList.remove('is-paused');
			schedule();
		}

		prev?.addEventListener('click', () => go(current - 1));
		next?.addEventListener('click', () => go(current + 1));
		dots.forEach((dot, index) => dot.addEventListener('click', () => go(index)));

		hero.addEventListener('mouseenter', pause);
		hero.addEventListener('mouseleave', resume);
		hero.addEventListener('focusin', pause);
		hero.addEventListener('focusout', (event) => {
			if (!hero.contains(event.relatedTarget)) resume();
		});
		hero.addEventListener('keydown', (event) => {
			if (event.key === 'ArrowLeft') { event.preventDefault(); go(current + 1); }
			if (event.key === 'ArrowRight') { event.preventDefault(); go(current - 1); }
		});

		let startX = null;
		hero.addEventListener('touchstart', (event) => { startX = event.touches[0].clientX; }, { passive: true });
		hero.addEventListener('touchend', (event) => {
			if (startX === null) return;
			const delta = event.changedTouches[0].clientX - startX;
			if (Math.abs(delta) > 45) go(delta > 0 ? current - 1 : current + 1);
			startX = null;
		});
		document.addEventListener('visibilitychange', () => {
			if (document.hidden) pause();
			else resume();
		});

		restartProgress();
		schedule();
	}

	/* ---------------------------------------------------------------------
	 * Search
	 * ------------------------------------------------------------------- */
	function initSearch() {
		const dialog = document.querySelector('#search-panel');
		if (!dialog) return;
		initDialogBasics(dialog);
		const input = dialog.querySelector('[data-sm-search-input]');
		const clear = dialog.querySelector('[data-sm-search-clear]');
		const results = dialog.querySelector('[data-sm-search-results]');
		const status = dialog.querySelector('[data-sm-search-status]');
		let controller = null;
		let debounce = null;

		function reset() {
			if (results) results.innerHTML = '';
			if (status) status.textContent = '';
			if (clear) clear.hidden = true;
			if (controller) controller.abort();
		}

		async function search() {
			const term = input.value.trim();
			if (term.length < 2) {
				reset();
				return;
			}
			if (clear) clear.hidden = false;
			if (status) status.textContent = strings.searching || '…';
			if (controller) controller.abort();
			controller = new AbortController();
			try {
				const url = new URL(data.ajaxUrl, window.location.origin);
				url.searchParams.set('action', 'sportmall_search');
				url.searchParams.set('nonce', data.nonce);
				url.searchParams.set('term', term);
				const response = await fetch(url, { signal: controller.signal });
				const json = await response.json();
				if (!json.success) throw new Error('search');
				const payload = json.data || {};
				if (results) {
					results.innerHTML = payload.html || '<p class="search-empty">' + escapeHtml(strings.noResults || '') + '</p>';
					if (payload.viewAll) {
						results.insertAdjacentHTML('beforeend', '<a class="search-view-all" href="' + escapeHtml(payload.viewAll) + '">' + escapeHtml(strings.viewAllResults || '') + '</a>');
					}
				}
				if (status) status.textContent = '';
			} catch (error) {
				if (error.name === 'AbortError') return;
				if (status) status.textContent = strings.loadError || '';
			}
		}

		input?.addEventListener('input', () => {
			clearTimeout(debounce);
			debounce = setTimeout(search, 260);
		});
		clear?.addEventListener('click', () => {
			input.value = '';
			reset();
			input.focus();
		});
	}

	/* ---------------------------------------------------------------------
	 * Cart drawer
	 * ------------------------------------------------------------------- */
	function updateCartCountText() {
		const badge = document.querySelector('.header-action--cart .sm-cart-count');
		const text = document.querySelector('[data-sm-cart-count-text]');
		if (!text) return;
		const count = badge && !badge.hidden ? badge.textContent.trim() : '۰';
		text.textContent = (count || '۰') + ' کالا';
	}

	function initCart() {
		const drawer = document.querySelector('#cart-panel');
		if (!drawer) return;
		initDialogBasics(drawer);

		if (window.jQuery) {
			const $ = window.jQuery;
			$(document.body).on('added_to_cart', function () {
				openDialog(drawer, document.querySelector('.header-action--cart'));
				toast(strings.addedToCart || '');
			});
			$(document.body).on('wc_fragments_refreshed wc_fragments_loaded', updateCartCountText);
		}
		updateCartCountText();
	}

	/* ---------------------------------------------------------------------
	 * Wishlist
	 * ------------------------------------------------------------------- */
	const WISHLIST_KEY = 'sportmall-favorites-v1';

	function readWishlist() {
		try {
			const value = JSON.parse(localStorage.getItem(WISHLIST_KEY) || '[]');
			return Array.isArray(value) ? value.map(String).filter(Boolean) : [];
		} catch (error) {
			return [];
		}
	}

	function writeWishlist(ids) {
		try {
			localStorage.setItem(WISHLIST_KEY, JSON.stringify(ids));
		} catch (error) {
			/* Storage may be unavailable. */
		}
	}

	function productName(button) {
		const card = button.closest('.product-card, .product');
		return card?.querySelector('.product-name')?.textContent.trim() || '';
	}

	function syncWishlistUI() {
		const ids = readWishlist();
		document.querySelectorAll('[data-sm-favorite]').forEach((button) => {
			const id = String(button.getAttribute('data-sm-favorite'));
			const active = ids.includes(id);
			button.setAttribute('aria-pressed', String(active));
			const name = productName(button);
			button.setAttribute('aria-label', (active ? 'حذف از' : 'افزودن به') + ' علاقه‌مندی‌ها' + (name ? ': ' + name : ''));
		});
		document.querySelectorAll('[data-sm-wishlist-count]').forEach((badge) => {
			badge.textContent = faDigits(ids.length);
			badge.hidden = ids.length === 0;
		});
		const empty = document.querySelector('[data-sm-wishlist-empty]');
		const grid = document.querySelector('[data-sm-wishlist-grid]');
		if (empty && grid) {
			empty.hidden = ids.length !== 0 || grid.children.length > 0;
		}
	}

	function toggleWishlist(id) {
		const ids = readWishlist();
		const index = ids.indexOf(String(id));
		const added = index === -1;
		if (added) ids.push(String(id));
		else ids.splice(index, 1);
		writeWishlist(ids);
		syncWishlistUI();
		toast(added ? strings.addedToWishlist : strings.removedFromWishlist);
		return added;
	}

	async function renderWishlistPage() {
		const page = document.querySelector('[data-sm-wishlist-page]');
		if (!page) return;
		const grid = page.querySelector('[data-sm-wishlist-grid]');
		const empty = page.querySelector('[data-sm-wishlist-empty]');
		const loading = page.querySelector('[data-sm-wishlist-loading]');
		const ids = readWishlist();
		syncWishlistUI();
		if (!ids.length) {
			if (grid) grid.innerHTML = '';
			if (loading) loading.hidden = true;
			if (empty) empty.hidden = false;
			return;
		}
		if (loading) loading.hidden = false;
		if (empty) empty.hidden = true;
		try {
			const params = new URLSearchParams();
			params.set('action', 'sportmall_wishlist');
			params.set('nonce', data.nonce);
			ids.forEach((id) => params.append('ids[]', id));
			const response = await fetch(data.ajaxUrl, { method: 'POST', body: params, credentials: 'same-origin' });
			const json = await response.json();
			if (!json.success) throw new Error('wishlist');
			if (grid) grid.innerHTML = json.data.html || '';
			if (loading) loading.hidden = true;
			const visible = grid ? grid.children.length : 0;
			if (empty) empty.hidden = visible !== 0;
			syncWishlistUI();
		} catch (error) {
			if (loading) {
				loading.innerHTML = '<p>' + escapeHtml(strings.loadError || '') + '</p>';
			}
		}
	}

	function initWishlist() {
		document.addEventListener('click', (event) => {
			const button = event.target.closest('[data-sm-favorite]');
			if (!button) return;
			event.preventDefault();
			const id = button.getAttribute('data-sm-favorite');
			const added = toggleWishlist(id);
			if (!added && document.querySelector('[data-sm-wishlist-page]')) {
				renderWishlistPage();
			}
		});
		syncWishlistUI();
		renderWishlistPage();
		window.addEventListener('storage', (event) => {
			if (event.key === WISHLIST_KEY) {
				syncWishlistUI();
				renderWishlistPage();
			}
		});
	}

	/* ---------------------------------------------------------------------
	 * Home catalog filters
	 * ------------------------------------------------------------------- */
	function initCatalog() {
		const catalog = document.querySelector('[data-sm-catalog]');
		if (!catalog) return;
		const tabs = Array.from(catalog.querySelectorAll('.product-tab[data-filter]'));
		const cards = Array.from(catalog.querySelectorAll('.product-card'));
		const count = catalog.querySelector('[data-sm-catalog-count]');
		const clear = catalog.querySelector('[data-sm-clear-filters]');
		const status = catalog.querySelector('[data-sm-filter-status]');

		function filter(slug) {
			let visible = 0;
			cards.forEach((card) => {
				const matches = slug === 'all' || (` ${card.getAttribute('data-cats')} `).includes(` ${slug} `);
				card.classList.toggle('is-hidden', !matches);
				if (matches) visible++;
			});
			tabs.forEach((tab) => tab.setAttribute('aria-pressed', String(tab.dataset.filter === slug)));
			if (count) count.textContent = faDigits(visible) + ' محصول';
			if (clear) clear.hidden = slug === 'all';
			if (status) {
				const tab = tabs.find((item) => item.dataset.filter === slug);
				status.textContent = slug === 'all' ? '' : 'نمایش ' + faDigits(visible) + ' محصول در «' + (tab ? tab.textContent.trim() : slug) + '»';
			}
			catalog.dataset.filter = slug;
		}

		tabs.forEach((tab) => tab.addEventListener('click', () => filter(tab.dataset.filter)));
		clear?.addEventListener('click', () => filter('all'));
	}

	/* ---------------------------------------------------------------------
	 * Outfit carousel
	 * ------------------------------------------------------------------- */
	function initOutfits() {
		const section = document.querySelector('[data-sm-outfits]');
		if (!section) return;
		const stages = Array.from(section.querySelectorAll('[data-sm-outfit-stage]'));
		const tabs = Array.from(section.querySelectorAll('[data-sm-outfit-tab]'));
		const counter = section.querySelector('[data-sm-outfit-counter]');
		const prev = section.querySelector('[data-sm-outfit-prev]');
		const next = section.querySelector('[data-sm-outfit-next]');
		if (stages.length < 2) return;
		let current = 0;

		function show(index) {
			current = (index + stages.length) % stages.length;
			stages.forEach((stage, i) => {
				stage.hidden = i !== current;
				stage.classList.toggle('is-active', i === current);
			});
			tabs.forEach((tab, i) => tab.setAttribute('aria-pressed', String(i === current)));
			if (counter) counter.textContent = faDigits(String(current + 1).padStart(2, '0')) + ' / ' + faDigits(String(stages.length).padStart(2, '0'));
			const active = stages[current];
			if (!reduceMotion) {
				active.classList.remove('is-changing');
				void active.offsetWidth;
				active.classList.add('is-changing');
			}
		}

		tabs.forEach((tab, index) => tab.addEventListener('click', () => show(index)));
		prev?.addEventListener('click', () => show(current - 1));
		next?.addEventListener('click', () => show(current + 1));
		section.addEventListener('keydown', (event) => {
			if (event.key === 'ArrowLeft') { event.preventDefault(); show(current + 1); }
			if (event.key === 'ArrowRight') { event.preventDefault(); show(current - 1); }
		});
		show(0);
	}

	/* ---------------------------------------------------------------------
	 * Copy discount code
	 * ------------------------------------------------------------------- */
	function initCopy() {
		document.addEventListener('click', async (event) => {
			const button = event.target.closest('[data-sm-copy]');
			if (!button) return;
			event.preventDefault();
			const value = button.getAttribute('data-sm-copy');
			let copied = false;
			try {
				await navigator.clipboard.writeText(value);
				copied = true;
			} catch (error) {
				const input = document.createElement('textarea');
				input.value = value;
				input.setAttribute('readonly', '');
				input.style.cssText = 'position:fixed;left:-9999px;top:0';
				document.body.appendChild(input);
				input.select();
				try { copied = document.execCommand('copy'); } catch (error2) { /* noop */ }
				input.remove();
			}
			toast(copied ? (strings.copied || '') : value);
		});
	}

	/* ---------------------------------------------------------------------
	 * Shop filters & ordering
	 * ------------------------------------------------------------------- */
	function initShop() {
		const sidebar = document.querySelector('[data-sm-shop-sidebar]');
		const toggles = Array.from(document.querySelectorAll('[data-sm-filter-toggle]'));
		if (sidebar) {
			toggles.forEach((button) => {
				button.addEventListener('click', () => {
					const open = !sidebar.classList.contains('is-open');
					sidebar.classList.toggle('is-open', open);
					document.body.classList.toggle('shop-filter-open', open);
					button.setAttribute('aria-expanded', String(open));
				});
			});
			const closeSidebar = () => {
				sidebar.classList.remove('is-open');
				document.body.classList.remove('shop-filter-open');
				toggles.forEach((button) => button.setAttribute('aria-expanded', 'false'));
			};

			sidebar.addEventListener('click', (event) => {
				if (event.target.closest('[data-sm-filter-toggle]')) closeSidebar();
			});

			document.addEventListener('click', (event) => {
				if (!document.body.classList.contains('shop-filter-open')) return;
				if (event.target.closest('#shop-sidebar') || event.target.closest('[data-sm-filter-toggle]')) return;
				closeSidebar();
			});

			document.addEventListener('keydown', (event) => {
				if (event.key === 'Escape' && document.body.classList.contains('shop-filter-open')) closeSidebar();
			});
		}

		// Keep active filters when changing the WooCommerce ordering select.
		document.querySelectorAll('.woocommerce-ordering select').forEach((select) => {
			select.addEventListener('change', () => {
				const form = select.closest('form');
				if (!form) return;
				const params = new URLSearchParams(window.location.search);
				params.forEach((value, key) => {
					if (key === 'orderby' || key === 'paged' || key === 'product-page') return;
					if (form.querySelector('input[name="' + key + '"]')) return;
					const hidden = document.createElement('input');
					hidden.type = 'hidden';
					hidden.name = key;
					hidden.value = value;
					form.appendChild(hidden);
				});
			});
		});
	}

	/* ---------------------------------------------------------------------
	 * Waitlist / misc
	 * ------------------------------------------------------------------- */
	function init() {
		initMarquee();
		initHeader();
		initHero();
		initSearch();
		initCart();
		initWishlist();
		initCatalog();
		initOutfits();
		initCopy();
		initShop();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init, { once: true });
	} else {
		init();
	}
})();
