# Cheremosh Ukrainian Dance Society — WordPress Theme

Capstone project by **Triad Studio** (NAIT DMIT Web Development): Michael, Daina, Sameer, Abdale.

This repo holds the **custom WordPress theme** for the new Cheremosh site. Everything below is how our team works together in it. If you're not sure about a step, ask in the team channel before pushing.

---

## Theme decision

**We are building a custom hybrid theme from scratch** (decided October 2026).

- **Classic PHP templates** for the site structure (`header.php`, `footer.php`, page and program templates).
- **Block editor** for page content, using **our own block patterns** so the client can edit pages without breaking the layout.
- **`theme.json`** for colours, fonts and spacing, added at the styling stage.
- **ACF (Advanced Custom Fields)** for structured content: programs, people (instructors, board, artistic director) and site settings (for example, turning the homepage banner on or off).
- **No page builders** (Elementor, Thrive, SiteOrigin) and **no parent or starter themes**.

**Build order:** structure → functionality → accessibility → styling.

---

## What goes in this repo (and what doesn't)

| ✅ In the repo | ❌ Not in the repo |
|---|---|
| Theme files: `style.css`, `functions.php`, `theme.json`, templates, template parts | WordPress core (`wp-admin`, `wp-includes`) |
| Theme assets: CSS, JS, fonts, theme images (logo, icons) | The database or any `.sql` exports |
| Block patterns, custom post types and ACF field groups saved as code | Uploaded media (`wp-content/uploads`) |
| This README and other docs | Plugins (we install and configure those on the site) |
| | Passwords, API keys, `wp-config.php` |

**The repo is the theme folder.** It does not include a WordPress install or sit inside a subfolder. WordPress core and plugins can be reinstalled anytime, and the database holds site-specific URLs and settings that break when you move it between computers. Only the theme is our code, so only the theme gets version-controlled.

---

## Our environments

- **Local (each of us):** your own WordPress install on your computer using Local (or MAMP). Use it to build and test your task. Only add enough sample content to test your feature (e.g. 2–3 sample programs, not the whole program list).
- **Staging site (client's Bluehost):** the "source of truth" for the build. Full content, plugins and settings live here, and it's what the client and instructor review. Being set up by the client. **Never copy your local database up to it, or its database down to you.**
- **Live site (cheremosh.ca):** hands off. Nobody changes the live site until the client and instructor approve launch.
- **GitHub (this repo):** where the theme code is shared, reviewed and merged.

---

## First-time setup

1. Install WordPress locally and log in to its admin.
2. Install and activate the **ACF** plugin.
3. Clone this repo **into your local site's themes folder** as `wp-content/themes/cheremosh-theme`. In GitHub Desktop: File → Clone Repository → pick this repo → set the local path to your `wp-content/themes/` folder.
4. In WP admin, go to **Appearance → Themes** and activate **Cheremosh**.
5. Set your Git name and email to match your GitHub account, so your commits show up under your name.

---

## The workflow (GitHub Flow)

**Rule #1: nobody pushes directly to `main`.** GitHub blocks it. `main` should always be stable and ready to deploy.

### 1. Start from an up-to-date `main`

In GitHub Desktop: switch to `main` → **Fetch origin** → **Pull origin**.

### 2. Make a branch for your task

One branch per Trello card. Name it `type/short-description`:

| Prefix | Use for | Example |
|---|---|---|
| `feature/` | New functionality or templates | `feature/mobile-nav` |
| `fix/` | Bug fixes | `fix/footer-links` |
| `style/` | CSS/visual-only changes | `style/button-colours` |
| `docs/` | README or documentation | `docs/theme-decision` |

In GitHub Desktop: Current Branch → **New Branch** → make sure it's based on `main`.

### 3. Do the work and commit often (Conventional Commits)

Start every commit message with a type, then say what changed in plain words:

- ✅ `feat: add mobile nav toggle and menu styles`
- ✅ `fix: correct registration button link on homepage`
- ✅ `docs: add theme decision to README`
- ❌ `stuff`, `update`, `changes`, `asdf`

| Type | Use for |
|---|---|
| `feat` | New feature or template |
| `fix` | Bug fix |
| `style` | Visual/CSS-only change |
| `docs` | README or documentation |
| `refactor` | Cleaning up code without changing what it does |
| `chore` | Setup, config, housekeeping |

Keep each commit to one logical change. Commit under **your own account** only. Your commit history is part of how individual contribution is graded.

### 4. Publish your branch and open a Pull Request (PR)

In GitHub Desktop: **Publish branch** → **Create Pull Request**.

- **PR title:** same wording as the Trello card.
- **Description:**
  - **What this does:** 1–2 sentences
  - **Trello card:** link
  - **How to test:** steps a teammate can follow locally
  - **Screenshots:** for anything visual

### 5. Code review

- **One other teammate** must review and approve before merging. You can't approve your own PR.
- Reviewers: pull the branch, test it locally, and leave comments on specific lines on GitHub.
- Check accessibility: headings in order, alt text on images, keyboard navigation works, form fields have labels.
- Don't edit someone else's branch directly. Leave a comment or bring it up with the team.
- Try to review within **12 hours on weekdays** (48 hours on weekends), per our team contract.

### 6. Merge and clean up

- Once approved, the **PR author** merges into `main`.
- Delete the branch after merging (GitHub offers a button).
- Everyone pulls `main` again before starting their next task.

---

## Merge conflicts

Conflicts are normal. They mean Git is stopping two people's changes from overwriting each other. When you hit one:

1. Don't panic, and don't force-push.
2. Pull the latest `main` into your branch.
3. Open the conflicted file. Git marks both versions between `<<<<<<<`, `=======` and `>>>>>>>`.
4. If the other change is a teammate's, **talk to them** and decide together what to keep.
5. Remove the markers, test locally, commit, and push.

---

## Code conventions

### Folder structure

    cheremosh-theme/
    ├── style.css
    ├── functions.php
    ├── theme.json
    ├── header.php
    ├── footer.php
    ├── index.php
    ├── front-page.php
    ├── page.php
    ├── single-program.php
    ├── archive-program.php
    ├── 404.php
    ├── inc/              (custom post types, ACF setup, helper functions)
    ├── patterns/         (our block patterns)
    ├── template-parts/
    ├── assets/
    │   ├── css/
    │   ├── js/
    │   └── images/
    └── README.md

### Rules

- **File names:** lowercase with hyphens (`program-card.php`, `mobile-nav.js`).
- **PHP functions:** prefix with `cheremosh_` so they don't clash with plugins (`cheremosh_register_programs()`).
- **CSS classes:** lowercase with hyphens (`.program-card`, `.site-header__nav`).
- **Comments:** add a short comment at the top of each template file saying what it's for, plus comments on anything that isn't obvious.
- **Mobile first:** write base styles for small screens, then add `min-width` media queries.
- **No hard-coded content:** anything the client might change (programs, dates, contact info) should be editable in WP admin.
- **Accessible by default:** semantic HTML, one `h1` per page, alt text on images, visible focus states, and a menu that works with the keyboard.

---

## Deploying to staging

We build and test on the **staging site**, not the live site. The live site stays untouched until the client and instructor approve launch.

- Only code merged into `main` goes to staging.
- **Before deploying:** take an UpdraftPlus backup of staging.
- **How:** _[automatic deploy from `main` once approved, or zip the theme folder from `main` and upload it in WP admin under Appearance → Themes → Add New → Upload Theme]_
- **Who deploys:** _[decide at standup]_
- **Plugins** (ACF, WPForms, WooCommerce, The Events Calendar, etc.) are installed and configured directly on the site. They are **not** stored in this repo.
- Deploying counts as a Trello task and gets logged in Toggl like any other work.

---

## Quick checklist (every task)

- [ ] Pulled latest `main`
- [ ] Created a branch named after the Trello card
- [ ] Used Conventional Commit messages under my own account
- [ ] Tested locally
- [ ] Checked accessibility (headings, alt text, keyboard, labels)
- [ ] Opened a PR titled with the Trello card, with test steps and screenshots
- [ ] Got a teammate's approval
- [ ] Merged and deleted the branch
- [ ] Updated the Trello card and logged my Toggl time