var post_stuff = document.getElementById("stuff");
var post_length = 0;

function add_form_data(name,value){
	let ip = document.createElement("input");
	ip.name=name;
	ip.value=value;
	ip.hidden=true;
	post_stuff.appendChild(ip);
}

function on_new_paragraph(ev,txt=""){
	post_length+=1;
	let ta = document.createElement("textarea");
	ta.maxLength=128;
	ta.placeholder="Absatz";
	ta.required=true;
	ta.name="element["+post_length+"][txt]";
	ta.value=txt;
	ta.classList.add("in_paragraph");
	post_stuff.appendChild(ta);
	add_form_data("element["+post_length+"][type]","txt");
}
document.getElementById("new_p").onclick=on_new_paragraph;

function on_new_header(ev,txt=""){
	post_length+=1;
	let ti = document.createElement("input");
	ti.type="text";
	ti.maxLength=64;
	ti.placeholder="Überschrift";
	ti.required=true;
	ti.classList.add("in_head");
	ti.name="element["+post_length+"][txt]";
	ti.value=txt;
	post_stuff.appendChild(ti);
	add_form_data("element["+post_length+"][type]","h");
}
document.getElementById("new_h").onclick=on_new_header;

function on_new_image(ev,url="",alt=""){
	post_length+=1;
	let iu = document.createElement("input");
	iu.type="url";
	iu.maxLength=128;
	iu.placeholder="Link zur Quelle";
	iu.required=true;
	iu.classList.add("in_imgurl");
	iu.name="element["+post_length+"][src]"
	iu.value=url;
	let ia = document.createElement("input");
	ia.type="text";
	ia.maxLength=128;
	ia.placeholder="Bildtext";
	ia.required=true;
	ia.classList.add("in_imgalt");
	ia.name="element["+post_length+"][alt]"
	ia.value=alt;
	post_stuff.appendChild(iu);
	post_stuff.appendChild(ia);
	add_form_data("element["+post_length+"][type]","img");
}
document.getElementById("new_i").onclick=on_new_image;

//recreating previous data from POST
function recreate_post_data(data){
	console.log(data);
	data.forEach(function(element){
		switch(element.type){
			case "txt":
				on_new_paragraph(null,element.txt);
				break;
			case "h":
				on_new_header(null,element.txt);
				break;
			case "img":
				on_new_image(null,element.src,element.alt);
				break;
			default:
				console.log("Unkown element: ");
				console.log(element);
		}
	});
}
recreate_post_data(JSON.parse(post_stuff.dataset.postData));