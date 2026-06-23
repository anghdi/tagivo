# Linear Design Tokens Configuration

Dokumen ini berisi terjemahan langsung dari `linear.app-DESIGN.md` ke dalam format kode yang siap disalin (copy-paste) ke dalam proyek web Anda.

---

## 1. Tailwind CSS Configuration (`tailwind.config.js`)

Jika proyek Anda menggunakan Tailwind CSS, salin objek di bawah ini dan masukkan ke dalam file `tailwind.config.js` Anda untuk menyelaraskan semua warna, font, dan jarak.

```javascript
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      colors: {
        // Brand & Accent
        primary: "#5e6ad2",
        "on-primary": "#ffffff",
        "primary-hover": "#828fff",
        "primary-focus": "#5e69d1",
        "brand-secure": "#7a7fad",
        
        // Surface Ladder
        canvas: "#010102",
        "surface-1": "#0f1011",
        "surface-2": "#141516",
        "surface-3": "#18191a",
        "surface-4": "#191a1b",
        
        // Hairlines / Borders
        hairline: "#23252a",
        "hairline-strong": "#34343a",
        "hairline-tertiary": "#3e3e44",
        
        // Typography Ink
        ink: "#f7f8f8",
        "ink-muted": "#d0d6e0",
        "ink-subtle": "#8a8f98",
        "ink-tertiary": "#62666d",
        
        // Semantic & Inverse
        "semantic-success": "#27a644",
        "semantic-overlay": "#000000",
        "inverse-canvas": "#ffffff",
        "inverse-surface-1": "#f5f6f6",
        "inverse-surface-2": "#f6f7f7",
        "inverse-ink": "#000000",
      },
      fontFamily: {
        // Direkomendasikan menggunakan Inter atau Geist jika font asli Linear tidak tersedia
        display: ["Linear Display", "SF Pro Display", "Inter", "sans-serif"],
        text: ["Linear Text", "SF Pro Text", "Inter", "sans-serif"],
        mono: ["Linear Mono", "SF Mono", "JetBrains Mono", "monospace"],
      },
      letterSpacing: {
        "display-xl": "-3.0px",
        "display-lg": "-1.8px",
        "display-md": "-1.0px",
        headline: "-0.6px",
        "card-title": "-0.4px",
        subhead: "-0.2px",
        "body-lg": "-0.1px",
        body: "-0.05px",
        eyebrow: "0.4px",
      },
      borderRadius: {
        xs: "4px",
        sm: "6px",
        md: "8px",
        lg: "12px",
        xl: "16px",
        xxl: "24px",
      },
      spacing: {
        xxs: "4px",
        xs: "8px",
        sm: "12px",
        md: "16px",
        lg: "24px",
        xl: "32px",
        xxl: "48px",
        section: "96px",
      }
    },
  },
  plugins: [],
}

:root {
  /* Brand & Accent */
  --color-primary: #5e6ad2;
  --color-on-primary: #ffffff;
  --color-primary-hover: #828fff;
  --color-primary-focus: #5e69d1;
  --color-brand-secure: #7a7fad;

  /* Surface Ladder */
  --color-canvas: #010102;
  --color-surface-1: #0f1011;
  --color-surface-2: #141516;
  --color-surface-3: #18191a;
  --color-surface-4: #191a1b;

  /* Hairlines / Borders */
  --color-hairline: #23252a;
  --color-hairline-strong: #34343a;
  --color-hairline-tertiary: #3e3e44;

  /* Typography Ink */
  --color-ink: #f7f8f8;
  --color-ink-muted: #d0d6e0;
  --color-ink-subtle: #8a8f98;
  --color-ink-tertiary: #62666d;

  /* Semantic & Inverse */
  --color-semantic-success: #27a644;
  --color-semantic-overlay: #000000;
  --color-inverse-canvas: #ffffff;
  --color-inverse-surface-1: #f5f6f6;
  --color-inverse-surface-2: #f6f7f7;
  --color-inverse-ink: #000000;

  /* Border Radius */
  --radius-xs: 4px;
  --radius-sm: 6px;
  --radius-md: 8px;
  --radius-lg: 12px;
  --radius-xl: 16px;
  --radius-xxl: 24px;
  --radius-pill: 9999px;

  /* Spacing */
  --spacing-xxs: 4px;
  --spacing-xs: 8px;
  --spacing-sm: 12px;
  --spacing-md: 16px;
  --spacing-lg: 24px;
  --spacing-xl: 32px;
  --spacing-xxl: 48px;
  --spacing-section: 96px;
}
