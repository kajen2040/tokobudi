const n=dom=(()=>{const a=e=>typeof e=="string"&&e.trim().slice(0,1)!=="<"?document.querySelectorAll(e):typeof e=="string"&&e.trim().slice(0,1)==="<"?[o(e)]:typeof e=="object"&&e instanceof NodeList?e:typeof e=="object"&&e instanceof HTMLElement?[e]:typeof e=="object"&&e instanceof SVGElement?[e]:e,o=e=>{const t=new DOMParser,l="text/html";return t.parseFromString(e,l).body.childNodes[0]},c=(e,t,l)=>{e[t]=l},y=()=>"xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g,e=>{let t=Math.random()*16|0;return(e=="x"?t:t&3|8).toString(16)}),h=e=>{let t=e.composedPath&&e.composedPath()||e.path,l=e.target;if(t!=null)return t.indexOf(window)<0?t.concat(window):t;if(l===window)return[window];function r(u,f){f=f||[];let s=u.parentNode;return s?r(s,f.concat(s)):f}return[l].concat(r(l),window)},i=e=>{c(e,"on",(t,l,r)=>(e.forEach(u=>{u.addEventListener(t,f=>{const s=y();typeof l=="string"?h(f).every(p=>p.matches&&p.matches(l)?(p[s]=r,p[s](p),delete p[s],!1):!0):(u[s]=l,u[s](f),delete u[s])},!1)}),e)),c(e,"css",(t,l)=>l===void 0&&typeof t!="object"?getComputedStyle(e[0])[t]:(e.forEach(r=>{if(typeof t=="object")for(const[u,f]of Object.entries(t))r.style[u]=f;else r.style[t]=l}),i(e),e)),c(e,"slideUp",(t=300,l=()=>{})=>(e.forEach(r=>{r.style.transitionProperty="height, margin, padding",r.style.transitionDuration=t+"ms",r.style.height=r.offsetHeight+"px",r.offsetHeight,r.style.overflow="hidden",r.style.height=0,r.style.paddingTop=0,r.style.paddingBottom=0,r.style.marginTop=0,r.style.marginBottom=0,window.setTimeout(()=>{r.style.display="none",r.style.removeProperty("height"),r.style.removeProperty("padding-top"),r.style.removeProperty("padding-bottom"),r.style.removeProperty("margin-top"),r.style.removeProperty("margin-bottom"),r.style.removeProperty("overflow"),r.style.removeProperty("transition-duration"),r.style.removeProperty("transition-property");const u=y();r[u]=l,r[u](r),delete r[u]},t)}),i(e),e)),c(e,"slideDown",(t=300,l=()=>{})=>(e.forEach(r=>{r.style.removeProperty("display");let u=window.getComputedStyle(r).display;u==="none"&&(u="block"),r.style.display=u;let f=r.offsetHeight;r.style.overflow="hidden",r.style.height=0,r.style.paddingTop=0,r.style.paddingBottom=0,r.style.marginTop=0,r.style.marginBottom=0,r.offsetHeight,r.style.transitionProperty="height, margin, padding",r.style.transitionDuration=t+"ms",r.style.height=f+"px",r.style.removeProperty("padding-top"),r.style.removeProperty("padding-bottom"),r.style.removeProperty("margin-top"),r.style.removeProperty("margin-bottom"),window.setTimeout(()=>{r.style.removeProperty("height"),r.style.removeProperty("overflow"),r.style.removeProperty("transition-duration"),r.style.removeProperty("transition-property");const s=y();r[s]=l,r[s](r),delete r[s]},t)}),i(e),e)),c(e,"fadeOut",(t=300,l=()=>{})=>(e.forEach(r=>{r.style.opacity=1,r.style.transitionProperty="opacity",r.style.transitionDuration=t+"ms",r.style.opacity=0,window.setTimeout(()=>{r.style.display="none",r.style.removeProperty("transition-property"),r.style.removeProperty("transition-duration"),r.style.removeProperty("opacity");const u=y();r[u]=l,r[u](r),delete r[u]},t)}),i(e),e)),c(e,"fadeIn",(t=300,l=()=>{})=>(e.forEach(r=>{let u=window.getComputedStyle(r).display;u==="none"&&(u="block"),r.style.display=u,r.style.opacity=0,r.style.transitionProperty="opacity",r.style.transitionDuration=t+"ms",window.setTimeout(()=>{r.style.opacity=1,window.setTimeout(()=>{r.style.removeProperty("transition-property"),r.style.removeProperty("transition-duration"),r.style.removeProperty("opacity")},t);const f=y();r[f]=l,r[f](r),delete r[f]},t)}),i(e),e)),c(e,"hide",()=>(e.forEach(t=>{t.style.display="none"}),i(e),e)),c(e,"show",()=>(e.forEach(t=>{t.style.display==="none"&&(t.style.display="block")}),i(e),e)),c(e,"clone",()=>{let t=[];return e.forEach(l=>{t.push(l.cloneNode(!0))}),i(t),t}),c(e,"each",t=>(e.forEach((l,r)=>{const u=y();l[u]=t,l[u](r,l),delete l[u]}),i(e),e)),c(e,"find",t=>{let l=[];return e.forEach(r=>{const u=r.querySelectorAll(t);u.length&&u.forEach(f=>{l.push(f)})}),i(l),l}),c(e,"hasClass",t=>{let l=!1;return e.forEach(r=>{r.classList.contains(t)&&(l=!0)}),l}),c(e,"removeClass",t=>(t.length&&t.split(" ").forEach(l=>{e.forEach(r=>{r.classList.remove(l)})}),i(e),e)),c(e,"addClass",t=>(t.length&&t.split(" ").forEach(l=>{e.forEach(r=>{r.classList.add(l)})}),i(e),e)),c(e,"is",t=>typeof t=="string"?(e[0].matches||e[0].matchesSelector||e[0].msMatchesSelector||e[0].mozMatchesSelector||e[0].webkitMatchesSelector||e[0].oMatchesSelector).call(e[0],t):e[0]===t),c(e,"attr",(t,l)=>{if(l===void 0&&typeof t!="object")if(e[0]!==void 0){const r=e[0].getAttribute(t);return r===null?void 0:r}else return;return e.forEach(r=>{if(typeof t=="object")for(const[u,f]of Object.entries(t))r.setAttribute(u,f);else r.setAttribute(t,l)}),i(e),e}),c(e,"removeAttr",t=>(e.forEach(l=>{l.removeAttribute(t)}),i(e),e)),c(e,"data",(t,l)=>{if(l===void 0){const r=e[0].getAttribute(`data-${t}`);return r===null?void 0:r}return e.forEach(r=>{r.setAttribute(`data-${t}`,l)}),i(e),e}),c(e,"width",t=>t===void 0?e===window?parseInt(window.innerWidth):typeof e[0]<"u"?parseInt(getComputedStyle(e[0]).width):null:(e===window?window.resizeTo(t,window.innerHeight):e.forEach(l=>{l.style.width=t}),i(e),e)),c(e,"height",t=>t===void 0?e===window?parseInt(window.innerHeight):typeof e[0]<"u"?parseInt(getComputedStyle(e[0]).height):null:(e===window?window.resizeTo(window.innerWidth,t):e.forEach(l=>{l.style.height=t}),i(e),e)),c(e,"css",(t,l)=>l===void 0&&typeof t!="object"?getComputedStyle(e[0])[t]:(e.forEach(r=>{if(typeof t=="object")for(const[u,f]of Object.entries(t))r.style[u]=f;else r.style[t]=l}),i(e),e)),c(e,"replaceWith",t=>{const l=[],r=a(t);return e.forEach((u,f)=>{r.forEach(s=>{let p=s;f>0&&(p=s.cloneNode(!0)),u.parentNode.insertBefore(p,u.nextSibling),l.push(p)}),u.remove()}),i(l),l}),c(e,"insertAfter",t=>{const l=[],r=a(t);return e.forEach(u=>{r.forEach((f,s)=>{let p=u;s>0&&(p=u.cloneNode(!0)),f.parentNode.insertBefore(p,f.nextSibling),l.push(p)})}),i(l),l}),c(e,"appendTo",t=>{const l=[],r=a(t);return e.forEach(u=>{r.forEach((f,s)=>{let p=u;s>0&&(p=u.cloneNode(!0)),f.appendChild(p),l.push(p)})}),i(l),l}),c(e,"append",t=>{const l=a(t);return e.forEach((r,u)=>{l.forEach(f=>{let s=f;u>0&&(s=f.cloneNode(!0)),r.appendChild(s)})}),i(e),e}),c(e,"remove",()=>(e.forEach(t=>{t.parentNode!==null&&t.parentNode.removeChild(t)}),i(e),e)),c(e,"first",()=>{const t=e[0]!==void 0?[e[0]]:[];return i(t),t}),c(e,"last",()=>{const t=e[e.length-1]!==void 0?[e[e.length-1]]:[];return i(t),t}),c(e,"val",t=>{if(t===void 0)if(e[0]instanceof HTMLSelectElement&&e[0].multiple){const l=[];for(const r of e[0].selectedOptions)l.push(r.value);return l}else return e[0].value;return e.forEach(l=>{if(l instanceof HTMLSelectElement){l.value="",typeof t!="object"&&(t=[t]);for(const r of t){const u=Array.from(l).find(f=>f.value==r);u!==void 0&&(u.selected=!0)}}else l.value=t}),i(e),e}),c(e,"html",t=>t===void 0?e[0].innerHTML:(e.forEach(l=>{l.innerHTML=t}),i(e),e)),c(e,"text",t=>t===void 0?e[0].textContent:(e.forEach(l=>{l.textContent=t}),i(e),e)),c(e,"filter",t=>{let l=[];return e.forEach((r,u)=>{const f=y();r[f]=t;const s=r[f](u,r);delete r[f],s&&l.push(r)}),i(l),l}),c(e,"closest",t=>{let l=[];return e.forEach(r=>{const u=r.closest(t);u!==null&&!l.filter(f=>f===u).length&&l.push(u)}),i(l),l}),c(e,"children",t=>{let l=[];return e.forEach(r=>{for(const u of r.children)if(t===void 0)l.push(u);else for(const f of r.querySelectorAll(t))f===u&&l.push(f)}),i(l),l}),c(e,"parent",()=>{let t=[];return e.forEach(l=>{const r=l.parentNode;r!==null&&!t.filter(u=>u===r).length&&t.push(r)}),i(t),t}),c(e,"prev",()=>{let t=[];return e.forEach(l=>{l.previousElementSibling!==null&&t.push(l.previousElementSibling)}),i(t),t}),c(e,"next",()=>{let t=[];return e.forEach(l=>{l.nextElementSibling!==null&&t.push(l.nextElementSibling)}),i(t),t}),c(e,"off",()=>{let t=[];return e.forEach(l=>{let r=l.cloneNode(!0);l.parentNode.replaceChild(r,l),t.push(r)}),i(t),t})};return window.dom=e=>{const t=a(e);return i(t),t}})();window.$=n;
