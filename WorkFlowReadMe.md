# Cheremosh Ukrainian Dance Society — WordPress Theme

Capstone project by **Triad Studio** (NAIT DMIT Web Development): Michael, Daina, Sam.

This repo holds the **custom WordPress theme** for the new Cheremosh site. Everything below is how our team works together in it. If you're not sure about a step, ask in the team channel before pushing.

---

## What goes in this repo (and what doesn't)

| ✅ In the repo | ❌ Not in the repo |
|---|---|
| Theme files: `style.css`, `functions.php`, templates, template parts | WordPress core (`wp-admin`, `wp-includes`) |
| Theme assets: CSS/Sass, JS, fonts, theme images (logo, icons) | The database or any `.sql` exports |
| Custom post type / block code that lives in the theme | Uploaded media (`wp-content/uploads`) |
| This README and other docs | Plugins (we install and configure those on the site) |
| | Passwords, API keys, `wp-config.php` |

**Why:** WordPress core and plugins can be reinstalled anytime. The database holds site-specific URLs and settings that break when you move it between computers. Only the theme is our code, so only the theme gets version-controlled.

---

## Our environments

- **Local (each of us):** your own WordPress install on your computer using Local (or MAMP). Use it to build and test your task. Only add enough sample content to test your feature (e.g. 2–3 sample programs, not the whole program list).
- **Client server (staging/live):** the "source of truth." The full content, plugins and settings live here. **Never copy your local database up to it, or its database down to you.**
- **GitHub (this repo):** where the theme code is shared, reviewed and merged.

---

## First-time setup

1. Install WordPress locally and log in to its admin.
2. Clone this repo **into your local site's themes folder**:
   `wp-content/themes/cheremosh-theme`
   - *GitHub Desktop:* File → Clone Repository → pick this repo → set the local path to your `wp-content/themes/` folder.
3. In WP admin, go to **Appearance → Themes** and activate **Cheremosh**.
4. Set your Git name and email to match your GitHub account, so your commits show up under your name.

---

## The workflow (GitHub Flow)

**Rule #1: nobody pushes directly to `main`. Ever.** `main` should always be stable and ready to upload to the client's server.

### 1. Start from an up-to-date `main`
- *GitHub Desktop:* switch to `main` → **Fetch origin** → **Pull origin**.

### 2. Make a branch for your task
One branch per Trello card. Name it `type/short-description`:

| Prefix | Use for | Example |
|---|---|---|
| `feature/` | New functionality or templates | `feature/mobile-nav` |
| `fix/` | Bug fixes | `fix/footer-links` |
| `style/` | CSS/visual-only changes | `style/button-colours` |
| `docs/` | README or documentation | `docs/workflow-readme` |

- *GitHub Desktop:* Current Branch → **New Branch** → make sure it's based on `main`.

### 3. Do the work and commit often
Write commit messages that say what changed, in plain words:

- ✅ `Add mobile nav toggle and menu styles`
- ✅ `Fix registration button link on homepage`
- ❌ `stuff`, `update`, `changes`, `asdf`

Keep each commit to one logical change. Commit under **your own account** only. Your commit history is part of how individual contribution is graded.

### 4. Push your branch and open a Pull Request (PR)
- *GitHub Desktop:* **Publish branch** → **Create Pull Request**.
- PR title: same wording as the Trello card.
- In the description, fill in:
  - **What this does:** 1–2 sentences
  - **Trello card:** link
  - **How to test:** steps a teammate can follow locally
  - **Screenshots:** for anything visual

### 5. Code review
- **At least one other teammate** must review and approve before merging. You can't approve your own PR.
- Reviewers: pull the branch, test it locally, and leave comments on specific lines on GitHub.
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

- **Folders:**
  ```
  cheremosh-theme/
  ├── assets/
  │   ├── css/
  │   ├── js/
  │   └── images/
  ├── template-parts/
  ├── inc/              ← custom post types, helper functions
  ├── functions.php
  ├── style.css
  └── README.md
  ```
- **File names:** lowercase with hyphens (`program-card.php`, `mobile-nav.js`).
- **PHP functions:** prefix with `cheremosh_` so they don't clash with plugins (`cheremosh_register_programs()`).
- **CSS classes:** lowercase with hyphens (`.program-card`, `.site-header__nav`).
- **Comments:** add a short comment at the top of each template file saying what it's for, plus comments on anything that isn't obvious.
- **Mobile first:** write base styles for small screens, then add `min-width` media queries.
- **No hard-coded content:** anything the client might change (programs, dates, contact info) should be editable in WP admin.

---

## Deploying to the client server

Only code that's been merged into `main` goes to the client server.

- **Who uploads:** _[decide at standup]_
- **How:** _[e.g. zip the theme from `main` and upload via WP admin, or SFTP. Confirm once we have hosting access]_
- Uploading counts as a Trello task and gets logged in Toggl like any other work.

---

## Quick checklist (every task)

- [ ] Pulled latest `main`
- [ ] Created a branch named after the Trello card
- [ ] Committed with clear messages under my own account
- [ ] Tested locally
- [ ] Opened a PR with test steps and screenshots
- [ ] Got a teammate's approval
- [ ] Merged and deleted the branch
- [ ] Moved/updated the Trello card and logged my Toggl time
