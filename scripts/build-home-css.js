/**
 * Builds public/goods/css/home.min.css: one small stylesheet for the homepage.
 *
 * It takes the stylesheets the homepage used to load separately (style.css, main.css,
 * Bootstrap 4.3.1 and Font Awesome 5.11.2), keeps only the rules whose selectors appear
 * in the homepage templates, and minifies the result. One local file instead of five
 * render-blocking requests (~330 KB) is the biggest single win for PageSpeed.
 *
 * It also appends the homepage's own CSS (pages/home*.css) and the shared partials
 * (partials/header.css, get-a-quote.css, footer.css), so the homepage needs no CSS requests.
 *
 * Re-run after editing style.css / main.css, any of those CSS files, or the homepage templates:
 *     npm run build:home-css
 */
import { readFileSync, writeFileSync } from 'node:fs';
import { PurgeCSS } from 'purgecss';
import CleanCSS from 'clean-css';

// Fonts are served from public/goods/fonts. "__FONTS__" is replaced with url('goods/fonts')
// by resources/views/goods/include/assets.blade.php when the CSS is inlined.
const FONTS = '__FONTS__/';

// The only text fonts the homepage actually renders (checked with Lighthouse's network log):
// Quicksand 500/700 for headings, Open Sans + Titillium Web in the About section. Lato is unused.
const LATIN = 'U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD';
const textFonts = [
    ['Quicksand', 500, 'quicksand-latin-500.woff2'],
    ['Quicksand', 700, 'quicksand-latin-700.woff2'],
    ['Open Sans', '300 800', 'opensans-latin-var.woff2'],
    ['Titillium Web', 400, 'titilliumweb-latin-400.woff2'],
].map(([family, weight, file]) =>
    `@font-face{font-family:"${family}";font-style:normal;font-weight:${weight};font-display:swap;` +
    `src:url(${FONTS}${file}) format("woff2");unicode-range:${LATIN}}`).join('\n');

// Same order as the <link> tags used to be, so the cascade is unchanged.
const sources = [
    {
        file: 'public/goods/css/style.css',
        // style.css has a stray "/" before the .hero-fixed rule. Browsers discard that rule,
        // so drop it here as well (keeps the page looking exactly the same).
        transform: (css) => css.replace(/\n\/\s*\r?\n(\/\*[^*]*\*\/\s*)*\.hero-fixed\s*\{[^}]*\}/, '\n'),
    },
    { file: 'public/goods/css/main.css' },
    { file: 'resources/css/home-vendor/bootstrap-4.3.1.min.css' },
    {
        file: 'resources/css/home-vendor/fontawesome-5.11.2-all.min.css',
        // Point the icon fonts at our own copies (woff2 only) and let text render while they load.
        transform: (css) => css
            .replace(/font-display:auto/g, 'font-display:swap')
            .replace(/src:url\(\.\.\/webfonts\/[^)]+\.eot\);/g, '')
            .replace(/src:url\(\.\.\/webfonts\/([\w-]+)\.eot\?#iefix\)[^}]*/g,
                (_, name) => `src:url(${FONTS}${name}.woff2) format("woff2")`),
    },
    // The homepage's own CSS and the shared partials, in the order the page loads them.
    // These are site-specific and already lean, so they are minified but not trimmed.
    { file: 'public/goods/css/pages/home.css', purge: false },
    { file: 'public/goods/css/partials/header.css', purge: false },
    { file: 'public/goods/css/partials/get-a-quote.css', purge: false },
    { file: 'public/goods/css/pages/home-testimonials.css', purge: false },
    { file: 'public/goods/css/partials/faqs.css', purge: false },
    { file: 'public/goods/css/partials/footer.css', purge: false },
];

// Everything that can put a class/id/tag on the homepage, including inline scripts
// that add classes at runtime (they're inside these templates too).
const content = [
    'resources/views/goods/index.blade.php',
    'resources/views/goods/include/assets.blade.php',
    'resources/views/goods/include/header.blade.php',
    'resources/views/goods/include/footer.blade.php',
    'resources/views/goods/include/get-a-quote.blade.php',
    'resources/views/goods/include/faqs.blade.php',
];

// Classes that only appear at runtime and aren't spelled out in the templates.
const safelist = {
    standard: [/^is-/, /^has-/, 'active', 'show', 'open', 'sticky', 'scrolled', 'fixed', 'hidden'],
    greedy: [/swiper/],
};

let out = `/* text fonts */\n${textFonts}\n`;
for (const src of sources) {
    let css = readFileSync(src.file, 'utf8');
    if (src.transform) css = src.transform(css);
    if (src.purge === false) {
        out += `/* ${src.file} */\n${css}\n`;
        continue;
    }
    const [result] = await new PurgeCSS().purge({
        content,
        css: [{ raw: css }],
        safelist,
        fontFace: true,
        keyframes: true,
        variables: false,
    });
    out += `/* ${src.file} */\n${result.css}\n`;
}

const min = new CleanCSS({ level: 1 }).minify(out);
if (min.errors.length) throw new Error(min.errors.join('\n'));
writeFileSync('public/goods/css/home.min.css', min.styles);
console.log(`home.min.css: ${(min.styles.length / 1024).toFixed(1)} KB`);
