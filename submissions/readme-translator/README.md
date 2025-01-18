## Chimoney Readme Translator

This code translates the chimoney readme from the main language (eng) to another language of choice. This is faster than translating one after the other.

The language are in language codes like `fr` for french

Other languages code can be gotten from here and added to the workflow yaml
https://cloud.google.com/translate/docs/languages  


Example
```yaml
- name: Adding README - French
        uses: dephraiim/translate-readme@main
        with:
          LANG: fr
```

## How to run
1. Go to `Actions` in the GitHub repo
2. At the left side click on `Chimoney Translator`
3. Then click `Run Workflow` and `Run Workflow`

The readme willl be translated to any language that was stated in the `main.yml` file
