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
- A **discussion board** plugin — `discussion-topics` post type, `_wpdiscussionboard.scss`

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
| `includes/woocommerce.php`, `includes/wp-bakery.php` | WooCommerce hooks; WPBakery custom elements. |
| Root `*.php` (`single-*`, `archive-*`, `taxonomy-*`, `page-*`, `index`, `header`, `footer`, `sidebar`) | Standard WordPress template hierarchy. |
| `templates/` | Custom **Page Templates** (selectable in the page editor — files with a `Template Name:` header). |
| `template-parts/` | Reusable partials pulled in via `get_template_part()`. |
| `woocommerce/`, `plugins/events-manager/` | Plugin template overrides — edit these, not the plugin files. |
| `js/main.js` | Main theme script (enqueued). `*.backup` files are stale copies. |
| `assets/` | Fonts and images bundled with the theme. |

## Styles / build

- **`style.css` (repo root) is the only stylesheet enqueued at runtime** — it is
  compiled output, not hand-edited (header note: "Start of from main.min.css").
- **`scss/`** holds the active source partials (`main.scss` imports `variables`,
  `mixins`, `components`, section styles, and per-plugin overrides). This compiles
  to `style.css`.
- **`stylesheets/`** is a large legacy Bootstrap-4 SASS scaffold inherited from
  the starter theme. It is **not** wired into the runtime (nothing enqueues it);
  treat it as dormant unless you confirm otherwise.
- There is **no `package.json`/`gulpfile`/`composer.json`**. SCSS is compiled by
  an editor extension (the committed `*.css.map` files indicate Live Sass
  Compiler or similar). To change styles: edit `scss/`, recompile to `style.css`
  with your Sass tool, and commit both.

## Key helpers in `functions.php`

- `hero($title, $description, $bg_image, $section_class)` — renders the page hero (returns HTML via `ob_*`).
- `header_class()` / `logo()` — switch to a dark header + alternate logo for certain post types/templates.
- `restrict_page_to_user_with_pluc()` — gates community/discussion pages to logged-in providers with a valid PLUC code.
- `provider_options()` — `<option>` list of the `providers` CPT.
- `gt_set_post_view()` / `gt_get_post_view()` — per-post view counter stored in `post_views_count` meta.
- `open_awards_pagination($query)`, `clean($string)`, `_date_format()`, `make_google_calendar_link()`.

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
