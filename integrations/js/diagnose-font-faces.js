document.fonts.onloadingdone = function(e) {
  for (var i=0; i<document.styleSheets.length; i++) {
    var sheet = document.styleSheets[i];
    var ownerNode = sheet.ownerNode

    var diagnostics = {
      id: ownerNode.id,
      href: ownerNode.href,
      tagName: ownerNode.tagName
    }

    // Don't count a node introduced by this plugin.
    if('font-awesome-official-v4shim-inline-css' === diagnostics.id){
      continue;
    }

    try {
      for(var j=0; j<sheet.cssRules.length; j++){
        /* Currently, this only looks for a version 4 font-family as a potential conflict.
         * To be complete, it would need to also look for version 5 font-family names and filter out those that
         * are introduced by the Font Awesome plugin, which will have a specific id on them.
         */
        if(sheet.cssRules[j] instanceof CSSFontFaceRule && 'FontAwesome' === sheet.cssRules[j].style.fontFamily) {
          console.log(`FOUND: a font-face with a font-family of FontAwesome is defined by a stylesheet with ownerNode attributes:`, diagnostics)

          /**
           * This is how we might remove a conflicting webfont load of Font Awesome. However, all we know for sure
           * is that this ownerNode is responsible for loading a stylesheet that defines a conflicting @font-face.
           * We don't know that if we remove that node that we're removing *only* a conflict. We may be removing more than
           * we want to remove.
           */
          // ownerNode.parentNode.removeChild(ownerNode)

          /**
           * This is a more surgical approach where, rather than removing the entire DOM node (the whole stylesheet),
           * we just disable the @font-face rule.
           */
          sheet.removeRule(sheet.cssRules[j])
        }
      }
    } catch(error) {
      console.log(`CANDIDATE: A stylesheet with the following ownerNode attributes may be defining a font-face with font-family FontAwesome:`, diagnostics)
    }
  }
}

