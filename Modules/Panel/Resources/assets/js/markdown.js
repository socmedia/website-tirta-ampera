import hljs from "highlight.js";
import php from "highlight.js/lib/languages/php";
import css from "highlight.js/lib/languages/css";
import javascript from "highlight.js/lib/languages/javascript";
import typescript from "highlight.js/lib/languages/typescript";
import python from "highlight.js/lib/languages/python";
import java from "highlight.js/lib/languages/java";
import ruby from "highlight.js/lib/languages/ruby";
import go from "highlight.js/lib/languages/go";
import rust from "highlight.js/lib/languages/rust";
import markdown from "highlight.js/lib/languages/markdown";
import ini from "highlight.js/lib/languages/ini";
import MarkdownIt from "markdown-it";

// Register all languages
hljs.registerLanguage("php", php);
hljs.registerLanguage("css", css);
hljs.registerLanguage("javascript", javascript);
hljs.registerLanguage("typescript", typescript);
hljs.registerLanguage("python", python);
hljs.registerLanguage("java", java);
hljs.registerLanguage("ruby", ruby);
hljs.registerLanguage("go", go);
hljs.registerLanguage("rust", rust);
hljs.registerLanguage("markdown", markdown);
hljs.registerLanguage("ini", ini);

window.hljs = hljs;

// Alpine.js component
document.addEventListener("alpine:init", () => {
    Alpine.data("markdownComponent", () => ({
        markdownit: null,
        navbarHeight: 80,
        content: "",
        tocItems: [],
        headingIdCounts: {},

        init() {
            // Setup markdown-it
            this.markdownit = new MarkdownIt({
                html: true,
                linkify: true,
                typographer: true,
                highlight: (str, lang) => {
                    if (lang && hljs.getLanguage(lang)) {
                        try {
                            return `<code class="hljs theme-atom-one-dark language-${lang}">${
                                hljs.highlight(str, {
                                    language: lang,
                                    ignoreIllegals: true,
                                }).value
                            }</code>`;
                        } catch (_) {}
                    }
                    // Add badge class for inline code as well
                    return `<code class="hljs theme-atom-one-dark language-ini">${MarkdownIt().utils.escapeHtml(
                        str
                    )}</code>`;
                },
            });

            // Add id to all headings
            const slugify = (str) => {
                return str
                    .toLowerCase()
                    .replace(/[\s]+/g, "-")
                    .replace(/[^\w\-]+/g, "")
                    .replace(/\-\-+/g, "-")
                    .replace(/^-+/, "")
                    .replace(/-+$/, "");
            };

            // For each heading level, override the renderer to add id
            for (let level = 1; level <= 6; level++) {
                const ruleName = `heading_open`;
                const defaultHeadingOpen =
                    this.markdownit.renderer.rules[ruleName] ||
                    function (tokens, idx, options, env, self) {
                        return self.renderToken(tokens, idx, options);
                    };

                this.markdownit.renderer.rules[ruleName] = function (
                    tokens,
                    idx,
                    options,
                    env,
                    self
                ) {
                    const token = tokens[idx];
                    // Only add id for heading tokens
                    if (token.tag && /^h[1-6]$/.test(token.tag)) {
                        // Find the next token which is the inline content
                        const inlineToken = tokens[idx + 1];
                        let text = "";
                        if (inlineToken && inlineToken.type === "inline") {
                            text = inlineToken.content;
                        }
                        let slug = slugify(text);
                        // Ensure unique id for duplicate headings
                        if (!env.headingIdCounts) env.headingIdCounts = {};
                        if (!env.headingIdCounts[slug]) {
                            env.headingIdCounts[slug] = 1;
                        } else {
                            env.headingIdCounts[slug]++;
                            slug = `${slug}-${env.headingIdCounts[slug]}`;
                        }
                        // Remove suffix after last dash if it's a number and the base slug exists
                        // e.g. description-6 => description
                        //      data-flow-6 => data-flow
                        slug = slug.replace(/-\d+$/, "");
                        token.attrSet("id", slug);
                    }
                    return defaultHeadingOpen(tokens, idx, options, env, self);
                };
            }

            // Add badge class to inline code
            const defaultInlineCode =
                this.markdownit.renderer.rules.code_inline ||
                function (tokens, idx, options, env, self) {
                    return self.renderToken(tokens, idx, options);
                };
            this.markdownit.renderer.rules.code_inline = function (
                tokens,
                idx,
                options,
                env,
                self
            ) {
                // Add badge and badge-code classes
                tokens[idx].attrJoin(
                    "class",
                    "px-1 py-0.5 bg-gray-200 dark:bg-neutral-800 text-xs font-mono rounded"
                );
                return defaultInlineCode(tokens, idx, options, env, self);
            };

            // Extend table render
            const defaultOpen =
                this.markdownit.renderer.rules.table_open ||
                ((tokens, idx, options, env, self) =>
                    self.renderToken(tokens, idx, options));
            this.markdownit.renderer.rules.table_open = (
                tokens,
                idx,
                opts,
                env,
                self
            ) => {
                return (
                    '<div class="overflow-auto">' +
                    '<table class="divide-y divide-gray-200 dark:divide-neutral-700">' // add classes here
                );
            };

            const defaultClose =
                this.markdownit.renderer.rules.table_close ||
                ((tokens, idx, options, env, self) =>
                    self.renderToken(tokens, idx, options));
            this.markdownit.renderer.rules.table_close = (
                tokens,
                idx,
                opts,
                env,
                self
            ) => defaultClose(tokens, idx, opts, env, self) + "</div>";

            // Add classes to thead and tbody
            const addTableSectionClass =
                (section) => (tokens, idx, options, env, self) => {
                    // Get the rendered token
                    let token = tokens[idx];
                    // Only add class on opening tag
                    if (token.nesting === 1) {
                        return `<${section} class="divide-y divide-gray-200 dark:divide-neutral-700">`;
                    } else {
                        return `</${section}>`;
                    }
                };

            this.markdownit.renderer.rules.thead_open =
                addTableSectionClass("thead");
            this.markdownit.renderer.rules.tbody_open =
                addTableSectionClass("tbody");

            // Re-render after Livewire navigated
            document.addEventListener("livewire:navigated", () => {
                if (this.content) {
                    this.renderContent(this.content);
                }
            });
        },

        initContent() {
            const el = this.$el.querySelector("[x-ref='content']");
            if (el) {
                this.content = el.innerText.trim();
                this.renderContent(this.content);
            }
        },

        renderContent(content) {
            // Reset heading id counts for each render
            const env = { headingIdCounts: {} };
            const html = this.markdownit.render(content, env);

            // render ke element [x-ref="content"] agar Alpine tetap hidup
            const container = this.$el.querySelector("[x-ref='content']");
            if (container) container.innerHTML = html;

            // Build TOC (h2-h4)
            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = html;

            this.tocItems = [];
            tempDiv.querySelectorAll("h2,h3,h4").forEach((heading, i) => {
                if (!heading.id) heading.id = `section-${i}`;
                this.tocItems.push({
                    id: heading.id,
                    text: heading.textContent,
                    level:
                        heading.tagName === "H4"
                            ? 3
                            : heading.tagName === "H3"
                            ? 2
                            : 1,
                    goto: () => {
                        this.scrollToSection(heading.id);
                    },
                });
            });
        },

        scrollToSection(id) {
            const target = document.getElementById(id);
            console.log(target);
            if (target) {
                // Hitung posisi dengan memperhitungkan navbar
                const top =
                    target.getBoundingClientRect().top +
                    window.scrollY -
                    (this.navbarHeight + 300); // kasih extra margin 20px

                console.log({
                    getBoundingClientRect: target.getBoundingClientRect().top,
                    scrollY: window.scrollY,
                    navbarHeight: this.navbarHeight,
                    top,
                });

                window.scrollTo({
                    top,
                    behavior: "smooth",
                });
            }
        },
    }));
});
