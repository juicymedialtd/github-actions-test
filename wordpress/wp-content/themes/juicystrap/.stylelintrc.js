module.exports = {
  extends: ["stylelint-config-sass-guidelines"],
  plugins: ["stylelint-no-unsupported-browser-features"],
  rules: {
    "selector-class-pattern": [
      "^(([a-z][a-z0-9]*(-[a-z0-9]+)*))(__(([a-z0-9][a-z0-9]*(-[a-z0-9]+)*)))?(--(([a-z0-9][a-z0-9]*(-[a-z0-9]+)*)))?$",
      {
        resolveNestedSelectors: true,
        message:
          "Expect class selector to conform to kebab-case BEM, see https://github.com/Skyscanner/stylelint-config-skyscanner#class-selector-pattern for pattern (selector-class-pattern)",
      },
    ],
    "max-nesting-depth": 3,
    "selector-max-compound-selectors": 4,
    "plugin/no-unsupported-browser-features": [
      true,
      {
        severity: "error",
        ignore: [
          "calc",
          "css-featurequeries",
          "flexbox",
          "viewport-units",
          "multicolumn",
          "css-hyphens",
          "word-break",
          "object-fit",
          "css-nesting",
          "css-when-else",
        ],
        ignorePartialSupport: true,
      },
    ],
  },
};
