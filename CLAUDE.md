# CLAUDE.md

Guidance for working in this repository.

## What this is

A **classic WordPress theme** for the Open Awards website (an awarding
organisation / e-learning site). It is the theme directory itself
(`wp-content/themes/openawards`), not a full WordPress install — WordPress core,
plugins, and the database live outside this repo on the server.

The theme was scaffolded from the `naked-wordpress` starter (see `README.md`)
and heavily customised. Gutenberg is disabled; content is built with the
**WPBakery Page Builder** plus custom meta fields.

## ⚠️ The working tree is live-synced with a server

This directory is mirrored to a live server (paths in `error_log` point at
`/home/openawards3dd3/public_html/wp-content/themes/openawards/`). An external
sync/deploy process can **modify or delete files out from under you mid-edit**
(observed: `functions.php` rewritten and the whole `scss/` folder removed from
disk while still tracked in git). Before assuming a file's contents, re-read it.
After editing, verify the change persisted. Git is the source of truth, not the
working tree.

## Required plugins (not in this repo)

Code here depends on these being installed and active in WordPress:

- **WooCommerce** — shop, my-account, products-as-courses (`woocommerce/` overrides)
- **WPBakery Page Builder** (`vc_map`) — custom elements registered in `includes/wp-bakery.php`
- **Carbon Fields** — post meta defined in `includes/post-meta.php`
- **Advanced Custom Fields (ACF)** — `get_field()` is used in ~48 places
- **Events Manager** — template overrides in `plugins/events-manager/`
- A **discussion board** plugin — `discussion-topics` post type

Front-end libraries load from CDN in `functions.php`: Bootstrap 5.0.2, Swiper 10,
Fancybox 5, FontAwesome 5.15.

> Note: both **Carbon Fields** and **ACF** are in use. When adding/reading meta,
> match whatever the surrounding file already uses (`carbon_get_the_post_meta()`
> vs `get_field()`) rather than mixing them.

## Layout

| Path | Purpose |
|------|---------|
| `functions.php` | Theme bootstrap: theme supports, asset enqueue, menu + 6 widget areas, helper functions, `require`s of `includes/*`. |
| `includes/post-types.php` | Custom post types & taxonomies via the `newPostType` / `newTaxonomy` helper classes (Providers, Slider, Teams, Templates, FAQs, Success Stories, Students, Courses). |
| `includes/post-meta.php` | Carbon Fields meta containers. |
| `includes/shortcodes.php` | Shortcodes (e.g. `product_custom_field`, custom My Account). |
| `includes/ajax.php` | `admin-ajax` handlers (`resources`, `insert_post_ajax`). |
| `includes/search.php` | Advanced search module — self-contained, no dependencies. Enqueues assets, widens the native query (`pre_get_posts` + `posts_join`/`posts_search`/`posts_groupby` for meta + taxonomy matching), registers two AJAX endpoints: `oa_live_search` (modal preview) and `oa_search_results` (live refinement on `search.php`). Configurable via `oa_searchable_post_types()` / `oa_searchable_taxonomies()` filters. |
| `includes/woocommerce.php`, `includes/wp-bakery.php` | WooCommerce hooks; WPBakery custom elements. |
| `search.php` | Search results template. Query already widened by `includes/search.php`. Delegates rendering to `oa_render_search_results()` inside `#oaSearchResultsArea` — the same div the JS swaps on live refinement. |
| `search.css` | Search styles (enqueued by `includes/search.php`): modal overlay + toggle icon, live-results list, full-page result cards (`.oa-result-card`), pagination (`.pagination-holder`), and in-page refine form (`.oa-searchform`). All scoped under `.oa-search*` / `.oa-result*`. |
| `searchform.php` | `get_search_form()` override rendered inside `search.php` to let users refine results. |
| `js/search.js` | Vanilla-JS controller for two search surfaces: (1) the global modal (open/close, debounced AJAX, keyboard nav); (2) live refinement on `search.php` (intercepts the refine form + pagination clicks, swaps `#oaSearchResultsArea` via the `oa_search_results` endpoint, updates the URL with `history.pushState` and handles `popstate`). Localised with `OA_SEARCH` config. |
| Root `*.php` (`single-*`, `archive-*`, `taxonomy-*`, `page-*`, `index`, `header`, `footer`, `sidebar`) | Standard WordPress template hierarchy. |
| `templates/` | Custom **Page Templates** (selectable in the page editor — files with a `Template Name:` header). |
| `template-parts/` | Reusable partials pulled in via `get_template_part()`. |
| `woocommerce/`, `plugins/events-manager/` | Plugin template overrides — edit these, not the plugin files. |
| `js/main.js` | Main theme script (enqueued). `*.backup` files are stale copies. |
| `assets/` | Fonts and images bundled with the theme. |

## Styles / build

- **`style.css` (repo root) is the only stylesheet enqueued at runtime** (handle
  `style.css`; header note: "Start of from main.min.css"). **Edit this file
  directly** — it is the current source of truth for styles.
- **`scss/`** held the original source partials (`main.scss` → `variables`, `mixins`,
  `components`, section styles, per-plugin overrides). The live-server sync has
  deleted these files from disk; they survive only in git history. To restore:
  `git checkout HEAD -- scss/`. There is no `package.json`/`gulpfile`/`composer.json`
  — SCSS was compiled by an editor extension (Live Sass Compiler or similar). Note
  the server sync will likely delete them again.
- **`stylesheets/`** is a large legacy Bootstrap-4 SASS scaffold from the starter
  theme. Nothing enqueues it; treat it as dormant.

## Key helpers in `functions.php`

- `hero($title, $description, $bg_image, $section_class)` — renders the page hero (returns HTML via `ob_*`).
- `header_class()` / `logo()` — switch to a dark header + alternate logo for certain post types/templates.
- `restrict_page_to_user_with_pluc()` — gates community/discussion pages to logged-in providers with a valid PLUC code.
- `provider_options()` — `<option>` list of the `providers` CPT.
- `gt_set_post_view()` / `gt_get_post_view()` — per-post view counter stored in `post_views_count` meta.
- `open_awards_pagination($query)`, `clean($string)`, `_date_format()`, `make_google_calendar_link()`.
- `oa_search_toggle_button()` (in `includes/search.php`) — echoes the nav icon that opens the search modal; called from `header.php`.
- `oa_search_result_item($post_id, $context)` — renders one result item; `'live'` = compact modal row, `'page'` = full card.
- `oa_render_search_results(WP_Query $q, $page, $term)` — renders the swappable results region (cards + pagination or no-results notice) used by both `search.php` (server render) and the `oa_search_results` AJAX endpoint; keeps the two identical.
- `oa_search_count_text($count)` — returns a localised, pluralised "N results found." string used in the hero and AJAX response.
- `oa_search_pagination_html($total_pages, $current_page, $term)` — builds `?s=…&paged=N` pagination markup; JS intercepts clicks for in-place swaps; bare links are JS-free and crawlable.
- The legacy `__search_by_title_only` filter in `functions.php` skips any query that has `oa_enhanced_search` set, so the two search paths don't conflict.

## Conventions

- PHP indented with **tabs**; functions are loosely prefixed (`naked_`,
  `open_awards_`, `gt_`). Short-echo `<?= ?>` and `ob_start()/ob_get_clean()`
  for HTML-returning functions are used throughout — follow suit.
- Hook everything through `add_action` / `add_filter` / `add_shortcode`; register
  CPTs/taxonomies via the helper classes in `post-types.php`.
- No automated tests, linter, or CI. Verify changes by loading the affected page
  in a running WordPress install.

## Watch out for

- `includes/ajax.php` `insert_post_ajax()` reads `$_POST` without a nonce check
  and contains a `var_dump()` — pre-existing rough edges; don't copy the pattern
  into new code.
- `error_log` (PHP runtime log) and `*.backup` files are runtime/stale artifacts;
  `error_log` and `*.log` are git-ignored.
