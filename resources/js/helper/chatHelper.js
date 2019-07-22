
export const getSelection = () => {
    var txtarea = document.getElementById("editor");
    var start = txtarea.selectionStart;
    var finish = txtarea.selectionEnd;
    var sel = txtarea.value.substring(start, finish);
    return sel;
};
export const bold = () => {
    let sel = getSelection();
    if (sel.length > 0) {
      let newValue = document.getElementById("editor").value.replace(sel, '[b]'+sel+'[/b]');
      document.getElementById("editor").value = newValue;
    }
};
export const italic = () => {
    let sel = getSelection();
    if (sel.length > 0) {
      let newValue = document.getElementById("editor").value.replace(sel, '[i]'+sel+'[/i]');
      document.getElementById("editor").value = newValue;
    }
};
export const underline = () => {
    let sel = getSelection();
    if (sel.length > 0) {
      let newValue = document.getElementById("editor").value.replace(sel, '[u]'+sel+'[/u]');
      document.getElementById("editor").value = newValue;
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
