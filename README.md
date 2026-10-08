# vtHullenaar BV – peaceable-serval-4608d1.start.hosting.nl

WordPress build of the vtHullenaar website design (Atarim / hosting.nl workspace).

- **Theme:** Hello Elementor + child theme `hello-elementor-child` (this repo: `wp-content/themes/hello-elementor-child`).
  - `assets/vt.css` – design layer (glass cards, pills, marquee, switchers, waves, projects wall, responsive fixes).
  - `assets/vt.js` – front-end behaviour (marquee/wall loops, wave/blob decoration, tab + testimonial switchers). Skipped inside the Elementor editor.
- **Plugins:** Elementor, Ultimate Addons for Elementor (UAE) for the global header/footer (Navigation Menu widget bound to the `vt-main-menu` / `vt-footer-menu` WordPress menus).
- **Content:** every section is built from native Elementor containers/widgets (editable). Sections are styled by CSS classes prefixed `vt-` (Advanced → CSS Classes).
- `build/elementor-layout.php` – generator for the Elementor JSON of header, footer, Home and the inner page headers.
- `build/install.php` – the installer that was run on the site (media, pages, menus, UAE templates, Elementor kit); the generator is inlined where `$data` is built.
