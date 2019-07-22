export const textareaObj = () => {
    return document.getElementById("editor");
};
export const getSelection = () => {    
    var start = textareaObj().selectionStart;
    var finish = textareaObj().selectionEnd;
    var sel = textareaObj().value.substring(start, finish);
    return sel;
};
export const bold = () => {
    let sel = getSelection();
    if (sel.length > 0) {
      let newValue = textareaObj().value.replace(sel, '[b]'+sel+'[/b]');
      textareaObj().value = newValue;
    } else {
        insertAtCaret('[b][/b]')
    }
};
export const italic = () => {
    let sel = getSelection();
    if (sel.length > 0) {
      let newValue = textareaObj().value.replace(sel, '[i]'+sel+'[/i]');
      textareaObj().value = newValue;
    }  else {
        insertAtCaret('[i][/i]')
    }
};
export const underline = () => {
    let sel = getSelection();
    if (sel.length > 0) {
      let newValue = textareaObj().value.replace(sel, '[u]'+sel+'[/u]');
      textareaObj().value = newValue;
    } else {
        insertAtCaret('[u][/u]')
    }
};
export const atmark = () => {
    
};

export const selectSmile = () => {
    
};

export const selectImage = () => {
    
};

export const fontColor = () => {

};

export const fontSize = () => {

};

export const insertAtCaret = (text) => {
    var txtarea = textareaObj();
    if (!txtarea) {
      return;
    }
  
    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
      "ff" : (document.selection ? "ie" : false));
    if (br == "ie") {
      txtarea.focus();
      var range = document.selection.createRange();
      range.moveStart('character', -txtarea.value.length);
      strPos = range.text.length;
    } else if (br == "ff") {
      strPos = txtarea.selectionStart;
    }
  
    var front = (txtarea.value).substring(0, strPos);
    var back = (txtarea.value).substring(strPos, txtarea.value.length);
    txtarea.value = front + text + back;
    strPos = strPos + text.length;
    if (br == "ie") {
      txtarea.focus();
      var ieRange = document.selection.createRange();
      ieRange.moveStart('character', -txtarea.value.length);
      ieRange.moveStart('character', strPos);
      ieRange.moveEnd('character', 0);
      ieRange.select();
    } else if (br == "ff") {
      txtarea.selectionStart = strPos;
      txtarea.selectionEnd = strPos;
      txtarea.focus();
    }
  
    txtarea.scrollTop = scrollPos;
  }
