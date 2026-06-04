import fs from "node:fs";
import path from "node:path";

export interface PageMeta {
  currentPage: string;
  pageTitle: string;
  metaDescription: string;
}

const pages: Record<string, PageMeta> = {
  index: {
    currentPage: "home",
    pageTitle:
      "Insight Research | Premium Content Writing & Business Consultancy",
    metaDescription:
      "Transform your ideas into compelling content. Insight Research delivers pro-level writing, research, and consulting services tailored to your needs.",
  },
  blog: {
    currentPage: "blog",
    pageTitle: "Blog | Insight Research",
    metaDescription:
      "Expert insights on content writing, research, and business strategy from Insight Research.",
  },
  "case-studies": {
    currentPage: "case-studies",
    pageTitle: "Case Studies | Insight Research",
    metaDescription:
      "See how we've helped businesses transform their content strategy and achieve remarkable results.",
  },
  faq: {
    currentPage: "faq",
    pageTitle: "FAQ | Insight Research",
    metaDescription:
      "Frequently asked questions about our content writing, research, and consulting services.",
  },
  "writing-guides": {
    currentPage: "writing-guides",
    pageTitle: "Writing Guides | Insight Research",
    metaDescription:
      "Expert guides on content writing, copywriting, research, and business communication.",
  },
  "privacy-policy": {
    currentPage: "privacy-policy",
    pageTitle: "Privacy Policy | Insight Research",
    metaDescription:
      "Learn about how Insight Research collects, uses, and protects your personal information.",
  },
  "terms-of-service": {
    currentPage: "terms-of-service",
    pageTitle: "Terms of Service | Insight Research",
    metaDescription:
      "Read Insight Research's terms of service and understand our agreement with you.",
  },
};

export function getPageMeta(slug: string): PageMeta {
  return pages[slug] || pages.index;
}

export function loadContent(slug: string): string {
  const filePath = path.join(process.cwd(), "src/content", `${slug}.html`);
  return fs.readFileSync(filePath, "utf-8");
}
