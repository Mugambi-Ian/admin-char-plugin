const po2json = require("po2json");
const fs = require("fs");
const path = require("path");

const sourceDir = "./languages";
const targetDir = "./languages";

if (!fs.existsSync(targetDir)) {
  fs.mkdirSync(targetDir);
}

// Empty `msgid` `msgstr` present in *.po files cause a null first entry to all translation fields during parse
const removeNullValues = (obj) => {
  const keys = Object.keys(obj);
  const values = Object.values(obj);
  for (let i = 0; i < values.length; i++) {
    const val = values[i];
    if (Array.isArray(val) && val[0] === null) {
      obj[keys[i]] = val.slice(1);
    }
  }
  return obj;
};

fs.readdirSync(sourceDir).forEach((file) => {
  const fileName = path.join(sourceDir, file);
  if (path.extname(fileName) === ".po") {
    const fileContent = fs.readFileSync(fileName, "utf-8");
    let jsonContent = po2json.parse(fileContent);
    jsonContent = removeNullValues(jsonContent);
    const targetFileName = path.join(
      targetDir,
      path.basename(fileName, ".po") + ".json"
    );
    fs.writeFileSync(targetFileName, JSON.stringify(jsonContent), "utf-8");
    console.log(`Translation file ${targetFileName} generated successfully.`);
  }
});

console.log("Done.");
