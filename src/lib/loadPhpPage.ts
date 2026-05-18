import fs from "node:fs";
import path from "node:path";

type PhpPageData = {
  currentPage: string;
  pageTitle: string;
  metaDescription: string;
  body: string;
};

const FALLBACK_TITLE =
  "Insight Research | Premium Content Writing & Business Consultancy";
const FALLBACK_DESCRIPTION =
  "Transform your ideas into compelling content. Insight Research delivers pro-level writing, research, and consulting services tailored to your needs.";

function extractPhpVar(raw: string, name: string): string {
  const pattern = new RegExp(`\\$${name}\\s*=\\s*'((?:\\\\'|[^'])*)';`);
  const match = raw.match(pattern);
  if (!match) {
    return "";
  }
  return match[1].replace(/\\\\'/g, "'");
}

function extractBody(raw: string): string {
  const withoutHeader = raw.replace(
    /<\?php[\s\S]*?include\s+'header\.php';\s*\?>\s*/,
    "",
  );
  const body = withoutHeader.replace(
    /\s*<\?php\s*include\s+'footer\.php';\s*\?>\s*$/,
    "",
  );

  if (body === raw || body === withoutHeader) {
    throw new Error("Could not parse page body from PHP file.");
  }

  return body;
}

export function loadPhpPage(fileName: string): PhpPageData {
  const filePath = path.join(process.cwd(), fileName);
  const raw = fs.readFileSync(filePath, "utf8");

  return {
    currentPage: extractPhpVar(raw, "current_page"),
    pageTitle: extractPhpVar(raw, "page_title") || FALLBACK_TITLE,
    metaDescription:
      extractPhpVar(raw, "meta_description") || FALLBACK_DESCRIPTION,
    body: extractBody(raw),
  };
}
