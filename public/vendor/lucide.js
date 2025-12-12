
/**
 * @license lucide v0.561.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */

(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
  typeof define === 'function' && define.amd ? define(['exports'], factory) :
  (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.lucide = {}));
})(this, (function (exports) { 'use strict';

  const defaultAttributes = {
    xmlns: "http://www.w3.org/2000/svg",
    width: 24,
    height: 24,
    viewBox: "0 0 24 24",
    fill: "none",
    stroke: "currentColor",
    "stroke-width": 2,
    "stroke-linecap": "round",
    "stroke-linejoin": "round"
  };

  const createSVGElement = ([tag, attrs, children]) => {
    const element = document.createElementNS("http://www.w3.org/2000/svg", tag);
    Object.keys(attrs).forEach((name) => {
      element.setAttribute(name, String(attrs[name]));
    });
    if (children?.length) {
      children.forEach((child) => {
        const childElement = createSVGElement(child);
        element.appendChild(childElement);
      });
    }
    return element;
  };
  const createElement = (iconNode, customAttrs = {}) => {
    const tag = "svg";
    const attrs = {
      ...defaultAttributes,
      ...customAttrs
    };
    return createSVGElement([tag, attrs, iconNode]);
  };

  const getAttrs = (element) => Array.from(element.attributes).reduce((attrs, attr) => {
    attrs[attr.name] = attr.value;
    return attrs;
  }, {});
  const getClassNames = (attrs) => {
    if (typeof attrs === "string") return attrs;
    if (!attrs || !attrs.class) return "";
    if (attrs.class && typeof attrs.class === "string") {
      return attrs.class.split(" ");
    }
    if (attrs.class && Array.isArray(attrs.class)) {
      return attrs.class;
    }
    return "";
  };
  const combineClassNames = (arrayOfClassnames) => {
    const classNameArray = arrayOfClassnames.flatMap(getClassNames);
    return classNameArray.map((classItem) => classItem.trim()).filter(Boolean).filter((value, index, self) => self.indexOf(value) === index).join(" ");
  };
  const toPascalCase = (string) => string.replace(/(\w)(\w*)(_|-|\s*)/g, (g0, g1, g2) => g1.toUpperCase() + g2.toLowerCase());
  const replaceElement = (element, { nameAttr, icons, attrs }) => {
    const iconName = element.getAttribute(nameAttr);
    if (iconName == null) return;
    const ComponentName = toPascalCase(iconName);
    const iconNode = icons[ComponentName];
    if (!iconNode) {
      return console.warn(
        `${element.outerHTML} icon name was not found in the provided icons object.`
      );
    }
    const elementAttrs = getAttrs(element);
    const iconAttrs = {
      ...defaultAttributes,
      "data-lucide": iconName,
      ...attrs,
      ...elementAttrs
    };
    const classNames = combineClassNames(["lucide", `lucide-${iconName}`, elementAttrs, attrs]);
    if (classNames) {
      Object.assign(iconAttrs, {
        class: classNames
      });
    }
    const svgElement = createElement(iconNode, iconAttrs);
    return element.parentNode?.replaceChild(svgElement, element);
  };

  const AArrowDown = [
    ["path", { d: "m14 12 4 4 4-4" }],
    ["path", { d: "M18 16V7" }],
    ["path", { d: "m2 16 4.039-9.69a.5.5 0 0 1 .923 0L11 16" }],
    ["path", { d: "M3.304 13h6.392" }]
  ];

  const ALargeSmall = [
    ["path", { d: "m15 16 2.536-7.328a1.02 1.02 1 0 1 1.928 0L22 16" }],
    ["path", { d: "M15.697 14h5.606" }],
    ["path", { d: "m2 16 4.039-9.69a.5.5 0 0 1 .923 0L11 16" }],
    ["path", { d: "M3.304 13h6.392" }]
  ];

  const AArrowUp = [
    ["path", { d: "m14 11 4-4 4 4" }],
    ["path", { d: "M18 16V7" }],
    ["path", { d: "m2 16 4.039-9.69a.5.5 0 0 1 .923 0L11 16" }],
    ["path", { d: "M3.304 13h6.392" }]
  ];

  const Accessibility = [
    ["circle", { cx: "16", cy: "4", r: "1" }],
    ["path", { d: "m18 19 1-7-6 1" }],
    ["path", { d: "m5 8 3-3 5.5 3-2.36 3.5" }],
    ["path", { d: "M4.24 14.5a5 5 0 0 0 6.88 6" }],
    ["path", { d: "M13.76 17.5a5 5 0 0 0-6.88-6" }]
  ];

  const Activity = [
    [
      "path",
      {
        d: "M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"
      }
    ]
  ];

  const AirVent = [
    ["path", { d: "M18 17.5a2.5 2.5 0 1 1-4 2.03V12" }],
    ["path", { d: "M6 12H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" }],
    ["path", { d: "M6 8h12" }],
    ["path", { d: "M6.6 15.572A2 2 0 1 0 10 17v-5" }]
  ];

  const Airplay = [
    ["path", { d: "M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1" }],
    ["path", { d: "m12 15 5 6H7Z" }]
  ];

  const AlarmClockCheck = [
    ["circle", { cx: "12", cy: "13", r: "8" }],
    ["path", { d: "M5 3 2 6" }],
    ["path", { d: "m22 6-3-3" }],
    ["path", { d: "M6.38 18.7 4 21" }],
    ["path", { d: "M17.64 18.67 20 21" }],
    ["path", { d: "m9 13 2 2 4-4" }]
  ];

  const AlarmClockMinus = [
    ["circle", { cx: "12", cy: "13", r: "8" }],
    ["path", { d: "M5 3 2 6" }],
    ["path", { d: "m22 6-3-3" }],
    ["path", { d: "M6.38 18.7 4 21" }],
    ["path", { d: "M17.64 18.67 20 21" }],
    ["path", { d: "M9 13h6" }]
  ];

  const AlarmClockOff = [
    ["path", { d: "M6.87 6.87a8 8 0 1 0 11.26 11.26" }],
    ["path", { d: "M19.9 14.25a8 8 0 0 0-9.15-9.15" }],
    ["path", { d: "m22 6-3-3" }],
    ["path", { d: "M6.26 18.67 4 21" }],
    ["path", { d: "m2 2 20 20" }],
    ["path", { d: "M4 4 2 6" }]
  ];

  const AlarmClockPlus = [
    ["circle", { cx: "12", cy: "13", r: "8" }],
    ["path", { d: "M5 3 2 6" }],
    ["path", { d: "m22 6-3-3" }],
    ["path", { d: "M6.38 18.7 4 21" }],
    ["path", { d: "M17.64 18.67 20 21" }],
    ["path", { d: "M12 10v6" }],
    ["path", { d: "M9 13h6" }]
  ];

  const AlarmClock = [
    ["circle", { cx: "12", cy: "13", r: "8" }],
    ["path", { d: "M12 9v4l2 2" }],
    ["path", { d: "M5 3 2 6" }],
    ["path", { d: "m22 6-3-3" }],
    ["path", { d: "M6.38 18.7 4 21" }],
    ["path", { d: "M17.64 18.67 20 21" }]
  ];

  const AlarmSmoke = [
    ["path", { d: "M11 21c0-2.5 2-2.5 2-5" }],
    ["path", { d: "M16 21c0-2.5 2-2.5 2-5" }],
    ["path", { d: "m19 8-.8 3a1.25 1.25 0 0 1-1.2 1H7a1.25 1.25 0 0 1-1.2-1L5 8" }],
    ["path", { d: "M21 3a1 1 0 0 1 1 1v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a1 1 0 0 1 1-1z" }],
    ["path", { d: "M6 21c0-2.5 2-2.5 2-5" }]
  ];

  const Album = [
    ["rect", { width: "18", height: "18", x: "3", y: "3", rx: "2", ry: "2" }],
    ["polyline", { points: "11 3 11 11 14 8 17 11 17 3" }]
  ];

  // ... (the file continues with all icon definitions and exports)

  const createIcons = ({
    icons = iconAndAliases,
    nameAttr = "data-lucide",
    attrs = {},
    root = document,
    inTemplates
  } = {}) => {
    if (!Object.values(icons).length) {
      throw new Error(
        "Please provide an icons object.\nIf you want to use all the icons you can import it like:\n `import { createIcons, icons } from 'lucide';\nlucide.createIcons({icons});"
      );
    }
    if (typeof root === "undefined") {
      throw new Error("`createIcons()` only works in a browser environment.");
    }
    const elementsToReplace = Array.from(root.querySelectorAll(`[${nameAttr}]`));
    elementsToReplace.forEach((element) => replaceElement(element, { nameAttr, icons, attrs }));
    if (inTemplates) {
      const templates = Array.from(root.querySelectorAll("template"));
      templates.forEach(
        (template) => createIcons({
          icons,
          nameAttr,
          attrs,
          root: template.content,
          inTemplates
        })
      );
    }
    if (nameAttr === "data-lucide") {
      const deprecatedElements = root.querySelectorAll("[icon-name]");
      if (deprecatedElements.length > 0) {
        console.warn(
          "[Lucide] Some icons were found with the now deprecated icon-name attribute. These will still be replaced for backwards compatibility, but will no longer be supported in v1.0 and you should switch to data-lucide"
        );
        Array.from(deprecatedElements).forEach(
          (element) => replaceElement(element, { nameAttr: "icon-name", icons, attrs })
        );
      }
    }
  };

  exports.AArrowDown = AArrowDown;
  exports.AArrowUp = AArrowUp;
  exports.ALargeSmall = ALargeSmall;
  exports.Accessibility = Accessibility;
  exports.Activity = Activity;
  // ... (full exports list)
  exports.createElement = createElement;
  exports.createIcons = createIcons;
  exports.icons = iconAndAliases;

}));
//# sourceMappingURL=lucide.js.map
