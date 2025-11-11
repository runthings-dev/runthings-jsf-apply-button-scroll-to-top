# Build Commands

## Fresh Clone Setup

```bash
npm install
npm run build
```

## After JS Changes

```bash
npm run build
```

## Release Build

Bump version number in package.json, root plugin file, and define.

Update readme version number, changelog, upgrade notice, and stable tag.

```bash
npm run build
./bin/build-zip.sh
```

**Output:** `build/runthings-jsf-apply-button-scroll-to-top.zip`
