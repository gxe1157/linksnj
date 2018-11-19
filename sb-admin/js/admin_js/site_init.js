/* Site default setup */


function _(el){
  return document.getElementById(el);
}

function set_CI3_path() {
  if( _('base_url') && _('base_url').value !== undefined )
      return _('base_url').value;  
}

function jsUcfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

const dir_path = set_CI3_path();
