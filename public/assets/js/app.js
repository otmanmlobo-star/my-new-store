/* Placeholder JS - toggles dark mode (supports future theme settings) */
document.addEventListener('DOMContentLoaded', function(){
  const body=document.body;
  // simple theme toggle
  const t=localStorage.getItem('theme');
  if(t==='light') body.classList.remove('dark');
});
