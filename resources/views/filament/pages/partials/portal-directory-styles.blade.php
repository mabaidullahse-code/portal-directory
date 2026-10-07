<style>
    /* ==========================================================================
       ENTERPRISE PORTAL DIRECTORY COMPREHENSIVE STYLESHEET
       Self-contained, high-performance styling for all 9 directory architectural designs
       ========================================================================== */

    .portal-dir-container {
        font-family: inherit;
        color: #0f172a;
    }
    .dark .portal-dir-container {
        color: #f8fafc;
    }
    .portal-dir-container * {
        box-sizing: border-box;
    }
    .portal-dir-container a {
        text-decoration: none;
        color: inherit;
    }
    .portal-dir-container button {
        font-family: inherit;
    }

    /* SVG Guard */
    .portal-dir-container svg {
        display: inline-block;
        vertical-align: middle;
        flex-shrink: 0;
        max-width: 100%;
    }
    .portal-dir-container svg:not([width]):not([style*="width"]) {
        width: 1rem;
        height: 1rem;
    }

    /* Form Controls & Inputs */
    .portal-dir-container input[type="text"],
    .portal-dir-container select {
        width: 100%;
        border-radius: 0.75rem;
        border: 1px solid #cbd5e1;
        background-color: #ffffff;
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
        color: #0f172a;
        outline: none;
        transition: all 0.15s ease;
    }
    .dark .portal-dir-container input[type="text"],
    .dark .portal-dir-container select {
        border-color: #334155;
        background-color: #1e293b;
        color: #f8fafc;
    }
    .portal-dir-container input[type="text"]:focus,
    .portal-dir-container select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
    }
    .portal-dir-container .pl-10,
    .portal-dir-container input[type="text"].pl-10,
    .portal-dir-container input[type="text"][class*="pl-10"] { padding-left: 2.5rem !important; }
    .portal-dir-container .pl-9,
    .portal-dir-container input[type="text"].pl-9,
    .portal-dir-container input[type="text"][class*="pl-9"] { padding-left: 2.25rem !important; }
    .portal-dir-container .pr-3 { padding-right: 0.75rem; }
    .portal-dir-container .top-2\.5 { top: 0.625rem; }
    .portal-dir-container .left-3 { left: 0.75rem; }
    .portal-dir-container .left-3\.5 { left: 0.875rem; }

    .portal-dir-container .portal-search-icon-wrapper {
        position: absolute !important;
        left: 0.875rem !important;
        top: 0 !important;
        bottom: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        pointer-events: none !important;
        color: #94a3b8 !important;
    }

    /* Grid 12 Column Layout */
    .portal-dir-container .grid-cols-12 { grid-template-columns: repeat(12, minmax(0, 1fr)); }
    .portal-dir-container .col-span-12 { grid-column: span 12 / span 12; }
    .portal-dir-container .col-span-5 { grid-column: span 5 / span 5; }
    .portal-dir-container .col-span-3 { grid-column: span 3 / span 3; }
    .portal-dir-container .col-span-2 { grid-column: span 2 / span 2; }

    /* Executive Blue & Sky Palette */
    .portal-dir-container .bg-blue-50 { background-color: #eff6ff; }
    .portal-dir-container .bg-blue-100 { background-color: #dbeafe; }
    .portal-dir-container .bg-blue-100\/70 { background-color: rgba(219, 234, 254, 0.7); }
    .portal-dir-container .bg-blue-100\/80 { background-color: rgba(219, 234, 254, 0.8); }
    .portal-dir-container .bg-blue-200\/20 { background-color: rgba(191, 219, 254, 0.2); }
    .portal-dir-container .bg-blue-200\/25 { background-color: rgba(191, 219, 254, 0.25); }
    .portal-dir-container .bg-blue-600 { background-color: #2563eb; }
    .portal-dir-container .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
    .portal-dir-container .active\:bg-blue-800:active { background-color: #1e40af; }
    .portal-dir-container .text-blue-600 { color: #2563eb; }
    .portal-dir-container .text-blue-700 { color: #1d4ed8; }
    .portal-dir-container .text-blue-900 { color: #1e3a8a; }
    .portal-dir-container .border-blue-100\/80 { border-color: rgba(219, 234, 254, 0.8); }
    .portal-dir-container .border-blue-200\/70 { border-color: rgba(191, 219, 254, 0.7); }

    .portal-dir-container .from-white.via-sky-50\/30.to-blue-50\/50 {
        background: linear-gradient(135deg, #ffffff 0%, rgba(240, 249, 255, 0.4) 40%, rgba(239, 246, 255, 0.6) 100%);
    }
    .dark .portal-dir-container .from-white.via-sky-50\/30.to-blue-50\/50 {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
    }

    /* Core Hero Banner */
    .dir-hero-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
        border: 1px solid rgba(99, 102, 241, 0.25);
        border-radius: 1.25rem;
        padding: 1.75rem 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.3);
        color: #ffffff;
    }
    .dir-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        background: rgba(99, 102, 241, 0.2);
        border: 1px solid rgba(129, 140, 248, 0.35);
        color: #c7d2fe;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    .dir-stat-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        text-align: center;
    }

    /* Controls Bar & Buttons */
    .dir-controls-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        margin-top: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .dark .dir-controls-bar {
        background: #0f172a;
        border-color: #1e293b;
    }
    .dir-design-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.45rem 0.85rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #334155;
        transition: all 0.2s ease;
    }
    .dark .dir-design-btn {
        border-color: #334155;
        background: #1e293b;
        color: #cbd5e1;
    }
    .dir-design-btn:hover {
        background: #e2e8f0;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }
    .dark .dir-design-btn:hover {
        background: #334155;
        border-color: #475569;
    }
    .dir-design-btn.active {
        background: #4f46e5 !important;
        color: #ffffff !important;
        border-color: #4338ca !important;
        box-shadow: 0 4px 12px -2px rgba(79, 70, 229, 0.4);
    }
    .dir-dept-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        transition: all 0.15s ease;
    }
    .dark .dir-dept-pill {
        border-color: #334155;
        background: #1e293b;
        color: #94a3b8;
    }
    .dir-dept-pill:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .dark .dir-dept-pill:hover {
        background: #334155;
        color: #f8fafc;
    }
    .dir-dept-pill.active {
        background: #4f46e5 !important;
        color: #ffffff !important;
        border-color: #4338ca !important;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.35);
    }

    /* Layout: Flex & Grid */
    .portal-dir-container .flex { display: flex; }
    .portal-dir-container .inline-flex { display: inline-flex; }
    .portal-dir-container .grid { display: grid; }
    .portal-dir-container .block { display: block; }
    .portal-dir-container .inline-block { display: inline-block; }
    .portal-dir-container .hidden { display: none; }

    .portal-dir-container .flex-col { flex-direction: column; }
    .portal-dir-container .flex-row { flex-direction: row; }
    .portal-dir-container .flex-wrap { flex-wrap: wrap; }
    .portal-dir-container .items-center { align-items: center; }
    .portal-dir-container .items-start { align-items: flex-start; }
    .portal-dir-container .items-end { align-items: flex-end; }
    .portal-dir-container .justify-between { justify-content: space-between; }
    .portal-dir-container .justify-center { justify-content: center; }
    .portal-dir-container .justify-start { justify-content: flex-start; }
    .portal-dir-container .justify-end { justify-content: flex-end; }
    .portal-dir-container .flex-1 { flex: 1 1 0%; }
    .portal-dir-container .shrink-0 { flex-shrink: 0; }

    /* Grids */
    .portal-dir-container .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
    .portal-dir-container .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .portal-dir-container .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .portal-dir-container .col-span-full { grid-column: 1 / -1; }

    /* Gap Utilities */
    .portal-dir-container .gap-1 { gap: 0.25rem; }
    .portal-dir-container .gap-1\.5 { gap: 0.375rem; }
    .portal-dir-container .gap-2 { gap: 0.5rem; }
    .portal-dir-container .gap-2\.5 { gap: 0.625rem; }
    .portal-dir-container .gap-3 { gap: 0.75rem; }
    .portal-dir-container .gap-3\.5 { gap: 0.875rem; }
    .portal-dir-container .gap-4 { gap: 1rem; }
    .portal-dir-container .gap-5 { gap: 1.25rem; }
    .portal-dir-container .gap-6 { gap: 1.5rem; }
    .portal-dir-container .gap-8 { gap: 2rem; }

    /* Spacing & Dividers */
    .portal-dir-container .space-y-1 > * + * { margin-top: 0.25rem; }
    .portal-dir-container .space-y-2 > * + * { margin-top: 0.5rem; }
    .portal-dir-container .space-y-2\.5 > * + * { margin-top: 0.625rem; }
    .portal-dir-container .space-y-3 > * + * { margin-top: 0.75rem; }
    .portal-dir-container .space-y-4 > * + * { margin-top: 1rem; }
    .portal-dir-container .space-y-5 > * + * { margin-top: 1.25rem; }
    .portal-dir-container .space-y-6 > * + * { margin-top: 1.5rem; }
    .portal-dir-container .space-y-8 > * + * { margin-top: 2rem; }

    .portal-dir-container .divide-y > * + * { border-top: 1px solid #f1f5f9; }
    .dark .portal-dir-container .divide-y > * + * { border-top-color: #1e293b; }

    /* Dimensions */
    .portal-dir-container .w-full { width: 100%; }
    .portal-dir-container .w-2 { width: 0.5rem; }
    .portal-dir-container .h-2 { height: 0.5rem; }
    .portal-dir-container .w-2\.5 { width: 0.625rem; }
    .portal-dir-container .h-2\.5 { height: 0.625rem; }
    .portal-dir-container .w-8 { width: 2rem; }
    .portal-dir-container .h-8 { height: 2rem; }
    .portal-dir-container .w-9 { width: 2.25rem; }
    .portal-dir-container .h-9 { height: 2.25rem; }
    .portal-dir-container .w-10 { width: 2.5rem; }
    .portal-dir-container .h-10 { height: 2.5rem; }
    .portal-dir-container .w-12 { width: 3rem; }
    .portal-dir-container .h-12 { height: 3rem; }
    .portal-dir-container .w-16 { width: 4rem; }
    .portal-dir-container .h-16 { height: 4rem; }
    .portal-dir-container .w-72 { width: 18rem; }
    .portal-dir-container .h-72 { height: 18rem; }
    .portal-dir-container .w-80 { width: 20rem; }
    .portal-dir-container .h-80 { height: 20rem; }
    .portal-dir-container .w-96 { width: 24rem; }
    .portal-dir-container .h-96 { height: 24rem; }
    .portal-dir-container .w-\[500px\] { width: 500px; }
    .portal-dir-container .h-\[500px\] { height: 500px; }

    .portal-dir-container .min-w-0 { min-width: 0; }
    .portal-dir-container .min-h-\[580px\] { min-height: 580px; }
    .portal-dir-container .max-w-xs { max-width: 20rem; }
    .portal-dir-container .max-w-sm { max-width: 24rem; }
    .portal-dir-container .max-w-md { max-width: 28rem; }
    .portal-dir-container .max-w-lg { max-width: 32rem; }
    .portal-dir-container .max-w-2xl { max-width: 42rem; }
    .portal-dir-container .max-w-6xl { max-width: 72rem; }

    /* Positioning & Overflows */
    .portal-dir-container .relative { position: relative; }
    .portal-dir-container .absolute { position: absolute; }
    .portal-dir-container .inset-0 { inset: 0; }
    .portal-dir-container .-inset-3 { inset: -0.75rem; }
    .portal-dir-container .top-1\.5 { top: 0.375rem; }
    .portal-dir-container .left-1\.5 { left: 0.375rem; }
    .portal-dir-container .right-1\.5 { right: 0.375rem; }
    .portal-dir-container .bottom-1\.5 { bottom: 0.375rem; }
    .portal-dir-container .top-1\/2 { top: 50%; }
    .portal-dir-container .left-1\/2 { left: 50%; }
    .portal-dir-container .-translate-x-1\/2 { transform: translateX(-50%); }
    .portal-dir-container .-translate-y-1\/2 { transform: translateY(-50%); }
    .portal-dir-container .top-1\/2.left-1\/2.-translate-x-1\/2.-translate-y-1\/2 { transform: translate(-50%, -50%); }
    .portal-dir-container .-top-20 { top: -5rem; }
    .portal-dir-container .-right-20 { right: -5rem; }
    .portal-dir-container .-bottom-20 { bottom: -5rem; }
    .portal-dir-container .-left-20 { left: -5rem; }
    .portal-dir-container .-top-24 { top: -6rem; }
    .portal-dir-container .-right-24 { right: -6rem; }
    .portal-dir-container .-bottom-24 { bottom: -6rem; }
    .portal-dir-container .-left-24 { left: -6rem; }
    .portal-dir-container .top-10 { top: 2.5rem; }
    .portal-dir-container .left-1\/4 { left: 25%; }
    .portal-dir-container .bottom-10 { bottom: 2.5rem; }
    .portal-dir-container .right-1\/4 { right: 25%; }

    .portal-dir-container .overflow-hidden { overflow: hidden; }
    .portal-dir-container .overflow-x-auto { overflow-x: auto; }
    .portal-dir-container .pointer-events-none { pointer-events: none; }
    .portal-dir-container .z-10 { z-index: 10; }

    /* Padding Utilities */
    .portal-dir-container .p-1 { padding: 0.25rem; }
    .portal-dir-container .p-1\.5 { padding: 0.375rem; }
    .portal-dir-container .p-2 { padding: 0.5rem; }
    .portal-dir-container .p-2\.5 { padding: 0.625rem; }
    .portal-dir-container .p-3 { padding: 0.75rem; }
    .portal-dir-container .p-3\.5 { padding: 0.875rem; }
    .portal-dir-container .p-4 { padding: 1rem; }
    .portal-dir-container .p-5 { padding: 1.25rem; }
    .portal-dir-container .p-6 { padding: 1.5rem; }
    .portal-dir-container .p-7 { padding: 1.75rem; }
    .portal-dir-container .p-8 { padding: 2rem; }
    .portal-dir-container .p-12 { padding: 3rem; }

    .portal-dir-container .px-1\.5 { padding-left: 0.375rem; padding-right: 0.375rem; }
    .portal-dir-container .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
    .portal-dir-container .px-2\.5 { padding-left: 0.625rem; padding-right: 0.625rem; }
    .portal-dir-container .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
    .portal-dir-container .px-3\.5 { padding-left: 0.875rem; padding-right: 0.875rem; }
    .portal-dir-container .px-4 { padding-left: 1rem; padding-right: 1rem; }
    .portal-dir-container .px-5 { padding-left: 1.25rem; padding-right: 1.25rem; }
    .portal-dir-container .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
    .portal-dir-container .px-8 { padding-left: 2rem; padding-right: 2rem; }

    .portal-dir-container .py-0\.2 { padding-top: 0.1rem; padding-bottom: 0.1rem; }
    .portal-dir-container .py-0\.5 { padding-top: 0.125rem; padding-bottom: 0.125rem; }
    .portal-dir-container .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
    .portal-dir-container .py-1\.5 { padding-top: 0.375rem; padding-bottom: 0.375rem; }
    .portal-dir-container .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
    .portal-dir-container .py-2\.5 { padding-top: 0.625rem; padding-bottom: 0.625rem; }
    .portal-dir-container .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
    .portal-dir-container .py-3\.5 { padding-top: 0.875rem; padding-bottom: 0.875rem; }
    .portal-dir-container .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
    .portal-dir-container .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
    .portal-dir-container .py-10 { padding-top: 2.5rem; padding-bottom: 2.5rem; }

    .portal-dir-container .pt-0 { padding-top: 0; }
    .portal-dir-container .first\:pt-0:first-child { padding-top: 0 !important; }
    .portal-dir-container .pt-2 { padding-top: 0.5rem; }
    .portal-dir-container .pt-3 { padding-top: 0.75rem; }
    .portal-dir-container .pt-3\.5 { padding-top: 0.875rem; }
    .portal-dir-container .pt-4 { padding-top: 1rem; }
    .portal-dir-container .pt-6 { padding-top: 1.5rem; }

    .portal-dir-container .pb-1 { padding-bottom: 0.25rem; }
    .portal-dir-container .pb-2 { padding-bottom: 0.5rem; }
    .portal-dir-container .pb-2\.5 { padding-bottom: 0.625rem; }
    .portal-dir-container .pb-3 { padding-bottom: 0.75rem; }
    .portal-dir-container .pb-3\.5 { padding-bottom: 0.875rem; }
    .portal-dir-container .pb-4 { padding-bottom: 1rem; }
    .portal-dir-container .pb-5 { padding-bottom: 1.25rem; }

    /* Margins */
    .portal-dir-container .mt-0\.5 { margin-top: 0.125rem; }
    .portal-dir-container .mt-1 { margin-top: 0.25rem; }
    .portal-dir-container .mt-1\.5 { margin-top: 0.375rem; }
    .portal-dir-container .mt-2 { margin-top: 0.5rem; }
    .portal-dir-container .mt-3 { margin-top: 0.75rem; }
    .portal-dir-container .mt-4 { margin-top: 1rem; }
    .portal-dir-container .mt-6 { margin-top: 1.5rem; }

    .portal-dir-container .mb-1 { margin-bottom: 0.25rem; }
    .portal-dir-container .mb-1\.5 { margin-bottom: 0.375rem; }
    .portal-dir-container .mb-2 { margin-bottom: 0.5rem; }
    .portal-dir-container .mb-2\.5 { margin-bottom: 0.625rem; }
    .portal-dir-container .mb-3 { margin-bottom: 0.75rem; }
    .portal-dir-container .mb-3\.5 { margin-bottom: 0.875rem; }
    .portal-dir-container .mb-4 { margin-bottom: 1rem; }
    .portal-dir-container .mb-6 { margin-bottom: 1.5rem; }
    .portal-dir-container .mb-8 { margin-bottom: 2rem; }

    .portal-dir-container .ml-1 { margin-left: 0.25rem; }
    .portal-dir-container .mr-1 { margin-right: 0.25rem; }
    .portal-dir-container .mx-auto { margin-left: auto; margin-right: auto; }

    /* Border Radii */
    .portal-dir-container .rounded { border-radius: 0.25rem; }
    .portal-dir-container .rounded-md { border-radius: 0.375rem; }
    .portal-dir-container .rounded-lg { border-radius: 0.5rem; }
    .portal-dir-container .rounded-xl { border-radius: 0.75rem; }
    .portal-dir-container .rounded-2xl { border-radius: 1rem; }
    .portal-dir-container .rounded-3xl { border-radius: 1.5rem; }
    .portal-dir-container .rounded-full { border-radius: 9999px; }

    /* Border Widths & Sides */
    .portal-dir-container .border { border: 1px solid #e2e8f0; }
    .portal-dir-container .border-2 { border-width: 2px; }
    .portal-dir-container .border-t { border-top-width: 1px; }
    .portal-dir-container .border-b { border-bottom-width: 1px; }
    .portal-dir-container .border-l { border-left-width: 1px; }
    .portal-dir-container .border-r { border-right-width: 1px; }
    .portal-dir-container .border-t-2 { border-top-width: 2px; }
    .portal-dir-container .border-b-2 { border-bottom-width: 2px; }
    .portal-dir-container .border-l-2 { border-left-width: 2px; }
    .portal-dir-container .border-r-2 { border-right-width: 2px; }

    .dark .portal-dir-container .border { border-color: #1e293b; }

    /* Border Colors */
    .portal-dir-container .border-slate-100 { border-color: #f1f5f9; }
    .portal-dir-container .border-slate-200 { border-color: #e2e8f0; }
    .portal-dir-container .border-slate-300 { border-color: #cbd5e1; }
    .portal-dir-container .border-slate-700 { border-color: #334155; }
    .portal-dir-container .border-slate-800 { border-color: #1e293b; }
    .portal-dir-container .border-indigo-100 { border-color: #e0e7ff; }
    .portal-dir-container .border-indigo-200 { border-color: #c7d2fe; }
    .portal-dir-container .border-indigo-300 { border-color: #a5b4fc; }
    .portal-dir-container .border-indigo-400 { border-color: #818cf8; }
    .portal-dir-container .border-indigo-500 { border-color: #6366f1; }
    .portal-dir-container .border-cyan-200 { border-color: #a5f3fc; }
    .portal-dir-container .border-cyan-300 { border-color: #67e8f9; }
    .portal-dir-container .border-cyan-400 { border-color: #22d3ee; }
    .portal-dir-container .border-cyan-500 { border-color: #06b6d4; }
    .portal-dir-container .border-amber-200 { border-color: #fde68a; }
    .portal-dir-container .border-amber-300 { border-color: #fcd34d; }
    .portal-dir-container .border-amber-400 { border-color: #fbbf24; }
    .portal-dir-container .border-amber-500 { border-color: #f59e0b; }
    .portal-dir-container .border-violet-200 { border-color: #ddd6fe; }
    .portal-dir-container .border-violet-600 { border-color: #7c3aed; }
    .portal-dir-container .border-emerald-200 { border-color: #a7f3d0; }
    .portal-dir-container .border-emerald-500 { border-color: #10b981; }

    /* Typography */
    .portal-dir-container .text-\[10px\] { font-size: 10px; line-height: 14px; }
    .portal-dir-container .text-\[11px\] { font-size: 11px; line-height: 15px; }
    .portal-dir-container .text-xs { font-size: 0.75rem; line-height: 1rem; }
    .portal-dir-container .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
    .portal-dir-container .text-base { font-size: 1rem; line-height: 1.5rem; }
    .portal-dir-container .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
    .portal-dir-container .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
    .portal-dir-container .text-2xl { font-size: 1.5rem; line-height: 2rem; }
    .portal-dir-container .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }

    .portal-dir-container .font-normal { font-weight: 400; }
    .portal-dir-container .font-medium { font-weight: 500; }
    .portal-dir-container .font-semibold { font-weight: 600; }
    .portal-dir-container .font-bold { font-weight: 700; }
    .portal-dir-container .font-extrabold { font-weight: 800; }
    .portal-dir-container .font-black { font-weight: 900; }
    .portal-dir-container .font-mono { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }

    .portal-dir-container .tracking-tight { letter-spacing: -0.025em; }
    .portal-dir-container .tracking-wide { letter-spacing: 0.025em; }
    .portal-dir-container .tracking-wider { letter-spacing: 0.05em; }
    .portal-dir-container .tracking-widest { letter-spacing: 0.1em; }
    .portal-dir-container .uppercase { text-transform: uppercase; }

    .portal-dir-container .truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .portal-dir-container .whitespace-nowrap { white-space: nowrap; }
    .portal-dir-container .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .portal-dir-container .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .portal-dir-container .leading-snug { line-height: 1.375; }
    .portal-dir-container .leading-relaxed { line-height: 1.625; }
    .portal-dir-container .text-center { text-align: center; }
    .portal-dir-container .text-right { text-align: right; }

    /* Backgrounds & Text Colors */
    .portal-dir-container .bg-white { background-color: #ffffff; }
    .portal-dir-container .bg-white\/95 { background-color: rgba(255, 255, 255, 0.95); }
    .portal-dir-container .bg-slate-50 { background-color: #f8fafc; }
    .portal-dir-container .bg-slate-50\/50 { background-color: rgba(248, 250, 252, 0.5); }
    .portal-dir-container .bg-slate-50\/70 { background-color: rgba(248, 250, 252, 0.7); }
    .portal-dir-container .bg-slate-50\/80 { background-color: rgba(248, 250, 252, 0.8); }
    .portal-dir-container .bg-slate-100 { background-color: #f1f5f9; }
    .portal-dir-container .bg-slate-100\/70 { background-color: rgba(241, 245, 249, 0.7); }
    .portal-dir-container .bg-slate-100\/75 { background-color: rgba(241, 245, 249, 0.75); }
    .portal-dir-container .bg-slate-200 { background-color: #e2e8f0; }
    .portal-dir-container .bg-slate-800 { background-color: #1e293b; }
    .portal-dir-container .bg-slate-900 { background-color: #0f172a; }

    .portal-dir-container .text-slate-400 { color: #94a3b8; }
    .portal-dir-container .text-slate-500 { color: #64748b; }
    .portal-dir-container .text-slate-600 { color: #475569; }
    .portal-dir-container .text-slate-700 { color: #334155; }
    .portal-dir-container .text-slate-800 { color: #1e293b; }
    .portal-dir-container .text-slate-900 { color: #0f172a; }
    .portal-dir-container .text-white { color: #ffffff; }

    .portal-dir-container .bg-indigo-50 { background-color: #eef2ff; }
    .portal-dir-container .bg-indigo-100 { background-color: #e0e7ff; }
    .portal-dir-container .bg-indigo-500 { background-color: #6366f1; }
    .portal-dir-container .bg-indigo-600 { background-color: #4f46e5; }
    .portal-dir-container .bg-indigo-700 { background-color: #4338ca; }
    .portal-dir-container .text-indigo-600 { color: #4f46e5; }
    .portal-dir-container .text-indigo-700 { color: #4338ca; }
    .portal-dir-container .text-indigo-800 { color: #3730a3; }

    .portal-dir-container .bg-emerald-50 { background-color: #ecfdf5; }
    .portal-dir-container .bg-emerald-100 { background-color: #d1fae5; }
    .portal-dir-container .bg-emerald-500 { background-color: #10b981; }
    .portal-dir-container .text-emerald-600 { color: #059669; }
    .portal-dir-container .text-emerald-700 { color: #047857; }
    .portal-dir-container .text-emerald-800 { color: #065f46; }

    .portal-dir-container .bg-amber-100 { background-color: #fef3c7; }
    .portal-dir-container .bg-amber-500 { background-color: #f59e0b; }
    .portal-dir-container .bg-amber-600 { background-color: #d97706; }
    .portal-dir-container .text-amber-600 { color: #d97706; }
    .portal-dir-container .text-amber-700 { color: #b45309; }
    .portal-dir-container .text-amber-800 { color: #92400e; }

    .portal-dir-container .bg-cyan-50 { background-color: #ecfeff; }
    .portal-dir-container .bg-cyan-100 { background-color: #cffafe; }
    .portal-dir-container .bg-cyan-500 { background-color: #06b6d4; }
    .portal-dir-container .bg-cyan-600 { background-color: #0891b2; }
    .portal-dir-container .text-cyan-600 { color: #0891b2; }
    .portal-dir-container .text-cyan-700 { color: #0e7490; }
    .portal-dir-container .text-cyan-800 { color: #155e75; }

    .portal-dir-container .bg-violet-50 { background-color: #f5f3ff; }
    .portal-dir-container .bg-violet-100 { background-color: #ede9fe; }
    .portal-dir-container .bg-violet-600 { background-color: #7c3aed; }
    .portal-dir-container .text-violet-500 { color: #8b5cf6; }
    .portal-dir-container .text-violet-700 { color: #6d28d9; }
    .portal-dir-container .text-violet-800 { color: #5b21b6; }

    /* Gradients */
    .portal-dir-container .bg-gradient-to-r { background-image: linear-gradient(to right, var(--tw-gradient-stops, #4f46e5, #7c3aed)); }
    .portal-dir-container .bg-gradient-to-br { background-image: linear-gradient(135deg, var(--tw-gradient-stops, #4f46e5, #7c3aed)); }
    .portal-dir-container .bg-gradient-to-tr { background-image: linear-gradient(45deg, var(--tw-gradient-stops, #4f46e5, #ec4899)); }
    .portal-dir-container .bg-gradient-to-b { background-image: linear-gradient(180deg, var(--tw-gradient-stops, #f8fafc, #f1f5f9)); }

    .portal-dir-container .from-indigo-600.to-violet-600 { background: linear-gradient(135deg, #4f46e5, #7c3aed); }
    .portal-dir-container .from-indigo-500.via-purple-500.to-pink-500 { background: linear-gradient(to right, #6366f1, #a855f7, #ec4899); }
    .portal-dir-container .from-cyan-600.to-indigo-700 { background: linear-gradient(135deg, #0891b2, #4338ca); }
    .portal-dir-container .from-indigo-600.via-violet-600.to-pink-500 { background: linear-gradient(45deg, #4f46e5, #7c3aed, #ec4899); }
    .portal-dir-container .from-slate-50.to-indigo-50\/50 { background: linear-gradient(to right, #f8fafc, rgba(238, 242, 255, 0.5)); }
    .portal-dir-container .from-slate-50.via-indigo-50\/30.to-slate-100 { background: linear-gradient(180deg, #f8fafc 0%, rgba(238, 242, 255, 0.3) 50%, #f1f5f9 100%); }

    /* Shadows & Effects */
    .portal-dir-container .shadow-2xs { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .portal-dir-container .shadow-xs { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.06); }
    .portal-dir-container .shadow-sm { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1); }
    .portal-dir-container .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1); }
    .portal-dir-container .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1); }
    .portal-dir-container .shadow-xl { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); }
    .portal-dir-container .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }

    .portal-dir-container .backdrop-blur-md { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    .portal-dir-container .backdrop-blur-xl { backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); }
    .portal-dir-container .blur-lg { filter: blur(16px); }
    .portal-dir-container .blur-3xl { filter: blur(64px); }

    .portal-dir-container .transition { transition: all 0.15s ease; }
    .portal-dir-container .transition-all { transition: all 0.2s ease; }
    .portal-dir-container .duration-200 { transition-duration: 200ms; }
    .portal-dir-container .duration-300 { transition-duration: 300ms; }
    .portal-dir-container .duration-500 { transition-duration: 500ms; }
    .portal-dir-container .cursor-pointer { cursor: pointer; }

    /* Hover & Group Hover */
    .portal-dir-container .hover\:-translate-y-1:hover { transform: translateY(-4px); }
    .portal-dir-container .hover\:shadow-md:hover { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }
    .portal-dir-container .hover\:shadow-lg:hover { box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }
    .portal-dir-container .hover\:shadow-xl:hover { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15); }

    .portal-dir-container .hover\:bg-slate-50:hover { background-color: #f8fafc; }
    .portal-dir-container .hover\:bg-slate-100:hover { background-color: #f1f5f9; }
    .portal-dir-container .hover\:bg-indigo-50:hover { background-color: #eef2ff; }
    .portal-dir-container .hover\:bg-indigo-500:hover { background-color: #6366f1; }
    .portal-dir-container .hover\:bg-indigo-700:hover { background-color: #4338ca; }
    .portal-dir-container .hover\:bg-cyan-500:hover { background-color: #06b6d4; }
    .portal-dir-container .hover\:bg-amber-500:hover { background-color: #f59e0b; }

    .portal-dir-container .hover\:text-indigo-600:hover { color: #4f46e5; }
    .portal-dir-container .hover\:text-indigo-800:hover { color: #3730a3; }
    .portal-dir-container .hover\:text-slate-700:hover { color: #334155; }
    .portal-dir-container .hover\:border-indigo-300:hover { border-color: #a5b4fc; }
    .portal-dir-container .hover\:border-indigo-400:hover { border-color: #818cf8; }
    .portal-dir-container .hover\:border-indigo-500:hover { border-color: #6366f1; }

    .portal-dir-container .group:hover .group-hover\:text-indigo-600 { color: #4f46e5; }
    .portal-dir-container .group:hover .group-hover\:text-cyan-600 { color: #0891b2; }
    .portal-dir-container .group:hover .group-hover\:text-amber-600 { color: #d97706; }
    .portal-dir-container .group:hover .group-hover\:opacity-100 { opacity: 1; }
    .portal-dir-container .group:hover .group-hover\:scale-105 { transform: scale(1.05); }

    /* Custom Cards & Interactive Architecture Themes */
    .portal-glass-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        transition: all 0.25s ease;
    }
    .portal-glass-card:hover {
        transform: translateY(-2px);
        border-color: #6366f1;
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.15);
    }

    /* Cyber Matrix Canvas */
    .portal-cyber-canvas {
        background: #f8fafc;
        border: 1px solid #bae6fd;
        color: #0f172a;
        box-shadow: 0 10px 30px -10px rgba(6, 182, 212, 0.15);
    }
    .portal-cyber-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #0f172a;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        transition: all 0.25s ease;
    }
    .portal-cyber-card:hover {
        border-color: #06b6d4;
        box-shadow: 0 8px 24px -4px rgba(6, 182, 212, 0.2);
        transform: translateY(-2px);
    }

    /* Constellation Starfield Canvas */
    .portal-starfield-canvas {
        background: linear-gradient(180deg, #faf5ff 0%, #f5f3ff 100%);
        border: 1px solid #ddd6fe;
        color: #0f172a;
        box-shadow: 0 10px 30px -10px rgba(139, 92, 246, 0.15);
    }
    .portal-starfield-card {
        background: #ffffff;
        border: 1px solid #ede9fe;
        color: #0f172a;
        transition: all 0.25s ease;
    }
    .portal-starfield-card:hover {
        border-color: #a855f7;
        box-shadow: 0 8px 24px -4px rgba(139, 92, 246, 0.2);
        transform: translateY(-2px);
    }

    /* Terminal Console Canvas */
    .portal-terminal-canvas {
        background: #f8fafc;
        border: 2px solid #cbd5e1;
        color: #0f172a;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08);
    }
    .portal-terminal-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #0f172a;
        transition: all 0.25s ease;
    }
    .portal-terminal-card:hover {
        border-color: #f59e0b;
        box-shadow: 0 8px 24px -4px rgba(245, 158, 11, 0.18);
        transform: translateY(-2px);
    }

    /* Status Badges & Dot Rings */
    .portal-dir-container .bg-rose-50 { background-color: #fff1f2; }
    .portal-dir-container .text-rose-700 { color: #be123c; }
    .portal-dir-container .border-rose-200 { border-color: #fecdd3; }
    .portal-dir-container .bg-rose-500 { background-color: #f43f5e; }
    .portal-dir-container .bg-amber-50 { background-color: #fffbeb; }
    .portal-dir-container .border-amber-200 { border-color: #fde68a; }
    .portal-dir-container .ring-emerald-600\/20 { box-shadow: 0 0 0 1px rgba(5, 150, 105, 0.2); }
    .portal-dir-container .ring-slate-600\/20 { box-shadow: 0 0 0 1px rgba(71, 85, 105, 0.2); }
    .portal-dir-container .ring-amber-600\/20 { box-shadow: 0 0 0 1px rgba(217, 119, 6, 0.2); }
    .portal-dir-container .ring-rose-600\/20 { box-shadow: 0 0 0 1px rgba(225, 29, 72, 0.2); }

    /* Focus Rings */
    .portal-dir-container .ring-2 { box-shadow: 0 0 0 2px var(--tw-ring-color, #818cf8); }
    .portal-dir-container .ring-indigo-400 { --tw-ring-color: #818cf8; }
    .portal-dir-container .ring-violet-400 { --tw-ring-color: #a78bfa; }

    /* Opacities & Ambient Glows */
    .portal-dir-container .opacity-10 { opacity: 0.1; }
    .portal-dir-container .opacity-15 { opacity: 0.15; }
    .portal-dir-container .opacity-20 { opacity: 0.2; }
    .portal-dir-container .opacity-25 { opacity: 0.25; }
    .portal-dir-container .opacity-30 { opacity: 0.3; }
    .portal-dir-container .opacity-50 { opacity: 0.5; }
    .portal-dir-container .opacity-75 { opacity: 0.75; }
    .portal-dir-container .opacity-100 { opacity: 1; }
    .portal-dir-container .group:hover .group-hover\:opacity-75 { opacity: 0.75; }
    .portal-dir-container .group:hover .group-hover\:opacity-100 { opacity: 1; }
    .portal-dir-container .group\/p:hover .group-hover\/p\:text-indigo-600 { color: #4f46e5; }
    .dark .portal-dir-container .group\/p:hover .group-hover\/p\:text-indigo-300 { color: #a5b4fc; }

    .portal-dir-container .bg-indigo-500\/5 { background-color: rgba(99, 102, 241, 0.05); }
    .portal-dir-container .bg-indigo-500\/10 { background-color: rgba(99, 102, 241, 0.1); }
    .portal-dir-container .bg-cyan-500\/10 { background-color: rgba(6, 182, 212, 0.1); }
    .portal-dir-container .bg-emerald-500\/10 { background-color: rgba(16, 185, 129, 0.1); }
    .portal-dir-container .bg-purple-500\/10 { background-color: rgba(168, 85, 247, 0.1); }
    .portal-dir-container .bg-violet-500\/10 { background-color: rgba(139, 92, 246, 0.1); }
    .portal-dir-container .bg-black\/10 { background-color: rgba(0, 0, 0, 0.1); }
    .portal-dir-container .bg-black\/20 { background-color: rgba(0, 0, 0, 0.2); }
    .portal-dir-container .bg-black\/40 { background-color: rgba(0, 0, 0, 0.4); }

    /* Radial Canvas Dot Patterns */
    .portal-dir-container .bg-\[radial-gradient\(\#6366f1_1px\,transparent_1px\)\] {
        background-image: radial-gradient(#6366f1 1px, transparent 1px);
    }
    .portal-dir-container .bg-\[radial-gradient\(\#06b6d4_1px\,transparent_1px\)\] {
        background-image: radial-gradient(#06b6d4 1px, transparent 1px);
    }
    .portal-dir-container .bg-\[radial-gradient\(\#8b5cf6_1px\,transparent_1px\)\] {
        background-image: radial-gradient(#8b5cf6 1px, transparent 1px);
    }
    .portal-dir-container .\[background-size\:24px_24px\] { background-size: 24px 24px; }
    .portal-dir-container .\[background-size\:28px_28px\] { background-size: 28px 28px; }
    .portal-dir-container .\[background-size\:32px_32px\] { background-size: 32px 32px; }

    /* Animations */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    @keyframes ping {
        75%, 100% { transform: scale(2); opacity: 0; }
    }
    .portal-dir-container .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    .portal-dir-container .animate-ping { animation: ping 1.2s cubic-bezier(0, 0, 0.2, 1) infinite; }

    /* ==========================================================================
       DARK MODE OVERRIDES
       ========================================================================== */
    .dark .portal-glass-card {
        background: #1e293b;
        border-color: #334155;
        color: #f8fafc;
    }
    .dark .portal-glass-card:hover {
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.3);
    }
    .dark .portal-dir-container .dark\:bg-slate-800 { background-color: #1e293b; }
    .dark .portal-dir-container .dark\:bg-slate-900 { background-color: #0f172a; }
    .dark .portal-dir-container .dark\:bg-slate-950 { background-color: #020617; }
    .dark .portal-dir-container .dark\:bg-slate-800\/40 { background-color: rgba(30, 41, 59, 0.4); }
    .dark .portal-dir-container .dark\:bg-slate-800\/60 { background-color: rgba(30, 41, 59, 0.6); }
    .dark .portal-dir-container .dark\:bg-slate-800\/70 { background-color: rgba(30, 41, 59, 0.7); }
    .dark .portal-dir-container .dark\:bg-slate-800\/90 { background-color: rgba(30, 41, 59, 0.9); }
    .dark .portal-dir-container .dark\:bg-slate-900\/70 { background-color: rgba(15, 23, 42, 0.7); }
    .dark .portal-dir-container .dark\:bg-slate-900\/90 { background-color: rgba(15, 23, 42, 0.9); }
    .dark .portal-dir-container .dark\:bg-\[\#080f1e\] { background-color: #080f1e; }
    .dark .portal-dir-container .dark\:bg-\[\#090e1c\] { background-color: #090e1c; }
    .dark .portal-dir-container .dark\:bg-\[\#0b1324\] { background-color: #0b1324; }
    .dark .portal-dir-container .dark\:bg-\[\#0c1322\] { background-color: #0c1322; }

    .dark .portal-dir-container .dark\:text-white { color: #ffffff; }
    .dark .portal-dir-container .dark\:text-slate-200 { color: #e2e8f0; }
    .dark .portal-dir-container .dark\:text-slate-300 { color: #cbd5e1; }
    .dark .portal-dir-container .dark\:text-slate-400 { color: #94a3b8; }
    .dark .portal-dir-container .dark\:text-indigo-300 { color: #a5b4fc; }
    .dark .portal-dir-container .dark\:text-indigo-400 { color: #818cf8; }
    .dark .portal-dir-container .dark\:text-cyan-300 { color: #67e8f9; }
    .dark .portal-dir-container .dark\:text-cyan-400 { color: #22d3ee; }
    .dark .portal-dir-container .dark\:text-amber-400 { color: #fbbf24; }
    .dark .portal-dir-container .dark\:text-emerald-400 { color: #34d399; }
    .dark .portal-dir-container .dark\:text-violet-300 { color: #c4b5fd; }
    .dark .portal-dir-container .dark\:text-violet-400 { color: #a78bfa; }

    .dark .portal-dir-container .dark\:border-slate-700 { border-color: #334155; }
    .dark .portal-dir-container .dark\:border-slate-800 { border-color: #1e293b; }
    .dark .portal-dir-container .dark\:border-slate-700\/40 { border-color: rgba(51, 65, 85, 0.4); }
    .dark .portal-dir-container .dark\:border-slate-700\/80 { border-color: rgba(51, 65, 85, 0.8); }
    .dark .portal-dir-container .dark\:border-slate-800\/80 { border-color: rgba(30, 41, 59, 0.8); }

    .dark .portal-cyber-canvas {
        background: #060b17;
        color: #f8fafc;
        border-color: rgba(6, 182, 212, 0.45);
        box-shadow: 0 0 50px -12px rgba(6, 182, 212, 0.25);
    }
    .dark .portal-cyber-card {
        background: #0d1629;
        border-color: rgba(6, 182, 212, 0.35);
        color: #f8fafc;
    }
    .dark .portal-cyber-card:hover {
        border-color: #22d3ee;
        box-shadow: 0 0 25px rgba(6, 182, 212, 0.3);
    }

    .dark .portal-starfield-canvas {
        background: radial-gradient(circle at 50% 20%, #150f2e 0%, #060512 80%);
        color: #f8fafc;
        border-color: rgba(139, 92, 246, 0.45);
        box-shadow: 0 0 50px -12px rgba(139, 92, 246, 0.25);
    }
    .dark .portal-starfield-card {
        background: #0f0b24;
        border-color: rgba(139, 92, 246, 0.35);
        color: #f8fafc;
    }
    .dark .portal-starfield-card:hover {
        border-color: #c084fc;
        box-shadow: 0 0 25px rgba(168, 85, 247, 0.3);
    }

    .dark .portal-terminal-canvas {
        background: #070b14;
        color: #cbd5e1;
        border-color: #1e293b;
        box-shadow: 0 0 40px -12px rgba(0, 0, 0, 0.6);
    }
    .dark .portal-terminal-card {
        background: #0d1527;
        border-color: #1e293b;
        color: #f8fafc;
    }
    .dark .portal-terminal-card:hover {
        border-color: #f59e0b;
        box-shadow: 0 0 20px rgba(245, 158, 11, 0.25);
    }

    .dark .portal-dir-container .dark\:from-slate-950.dark\:via-slate-900.dark\:to-indigo-950 {
        background: linear-gradient(180deg, #020617 0%, #0f172a 50%, #1e1b4b 100%);
    }

    /* ==========================================================================
       RESPONSIVE BREAKPOINTS
       ========================================================================== */
    @media (min-width: 640px) {
        .portal-dir-container .sm\:flex-row { flex-direction: row; }
        .portal-dir-container .sm\:items-center { align-items: center; }
        .portal-dir-container .sm\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .portal-dir-container .sm\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .portal-dir-container .sm\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .portal-dir-container .sm\:p-7 { padding: 1.75rem; }
        .portal-dir-container .sm\:p-8 { padding: 2rem; }
        .portal-dir-container .sm\:text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .portal-dir-container .sm\:text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
    }

    @media (min-width: 768px) {
        .portal-dir-container .md\:flex-row { flex-direction: row; }
        .portal-dir-container .md\:items-center { align-items: center; }
        .portal-dir-container .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .portal-dir-container .md\:w-64 { width: 16rem; }
    }

    @media (min-width: 1024px) {
        .portal-dir-container .lg\:flex-row { flex-direction: row; }
        .portal-dir-container .lg\:items-center { align-items: center; }
        .portal-dir-container .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
</style>
