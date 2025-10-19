Self-hosted fonts for astra-rise

Place WOFF2 files in assets/fonts/ with the following filenames:

Inter (body)
- Inter-300.woff2
- Inter-400.woff2
- Inter-500.woff2
- Inter-600.woff2

Montserrat (headings)
- Montserrat-100.woff2
- Montserrat-200.woff2
- Montserrat-400.woff2
- Montserrat-600.woff2
- Montserrat-800.woff2

Permanent Marker (accent)
- PermanentMarker-400.woff2

Tips
- Use https://gwfh.mranftl.com/ (Google Webfonts Helper) to download subsets and WOFF2 files.
- Choose latin subset where possible to reduce size.
- Keep total critical font size under ~200KB for fastest LCP.

How it works
- If these files exist, the theme enqueues assets/css/fonts.css and preloads Inter-400, Montserrat-600, and PermanentMarker-400.
- If files are missing, the theme falls back to Google Fonts automatically.
