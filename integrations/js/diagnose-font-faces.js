document.fonts.onloadingdone = function(e) {
  for (var i=0; i<document.styleSheets.length; i++) {
    var sheet = document.styleSheets[i];
    var ownerNode = sheet.ownerNode

    var diagnostics = {
      id: ownerNode.id,
      href: ownerNode.href,
      tagName: ownerNode.tagName
    }

    try {
      for(var j=0; j<sheet.cssRules.length; j++){
        if(sheet.cssRules[j] instanceof CSSFontFaceRule && 'FontAwesome' === sheet.cssRules[j].style.fontFamily) {
          console.log(`FOUND: a font-face with a font-family of FontAwesome is defined by a stylesheet with ownerNode attributes:`, diagnostics)
        }
      }
    } catch(error) {
      console.log(`CANDIDATE: A stylesheet with the following ownerNode attributes may be defining a font-face with font-family FontAwesome:`, diagnostics)
    }
  }
}

