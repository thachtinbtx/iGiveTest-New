import type { Config } from "tailwindcss";

const config: Config = {
  content: [
    "./pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./components/**/*.{js,ts,jsx,tsx,mdx}",
    "./app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      colors: {
        'light-bg': '#F0F4F8', // A slightly lighter grey
        'dark-bg': '#1a1a1a',
        'text-light-contrast': '#0f172a',
        'accent': {
          DEFAULT: '#6366F1', // indigo-500 for light mode
          dark: '#22D3EE', // cyan-400 for dark mode
        },
        'shadow-light': 'rgba(163, 177, 198, 0.6)',
        'highlight-light': 'rgba(255, 255, 255, 0.5)',
      },
      boxShadow: {
        'neumorphic-light-raised': '10px 10px 20px #a3b1c6, -10px -10px 20px #ffffff',
        'neumorphic-light-inset': 'inset 10px 10px 20px #a3b1c6, inset -10px -10px 20px #ffffff',
        'glow-dark': '0 0 8px rgba(34, 211, 238, 0.6), 0 0 20px rgba(34, 211, 238, 0.4)',
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        mono: ['Fira Code', 'monospace'],
      },
      borderRadius: {
        '4xl': '2rem',
      },
      keyframes: {
        ripple: {
          to: {
            transform: 'scale(4)',
            opacity: '0',
          },
        },
      },
      animation: {
        ripple: 'ripple 850ms linear',
      },
    },
  },
  plugins: [],
};

export default config;