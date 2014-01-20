<script type="text/javascript" src="//www.google.com/jsapi"></script>
    <script type="text/javascript">
      function openBookByTitle(title) {
        showStatus('Searching for ' + title + '...');
        beginSearch(title);
      }

      function beginSearch(query) {
        // Dynamically load the search results in JavaScript,
        // using the Books API
        // Once loaded, handleResults is automatically called with
        // the result set
        var script = document.createElement("script");
        // We might need to supply a key for this or else we might run into
        // quota limits.
        script.src = 'https://www.googleapis.com/books/v1/volumes?q='
			+ encodeURIComponent(query) + '&filter=partial'
			+ '&maxResults=20'
          + '&callback=handleResults';
		script.type = "text/javascript";
		//alert(script.src);
        document.getElementsByTagName("head")[0].appendChild(script);
      }

      function handleResults(root) {
        // Find the identifier of the first embeddable match
        // If none found, report an error
        var entries = root.items || [];
		var nr = 0;
		document.getElementById('elenco_opere').innerHTML='';
		for (var i = 0; i < entries.length; ++i)
		{
			var entry = entries[i];
			showStatus('Trovati '+nr+' risultati. Cercando...');

			if('industryIdentifiers' in entry.volumeInfo)
			{
				++nr;
				var identifier = entry.id;
				var titolo = entry.volumeInfo.title;
				var autore = entry.volumeInfo.authors;
				var isbn = entry.volumeInfo.industryIdentifiers[1].identifier;
				var f = document.createElement("form");
				f.setAttribute('method',"post");
				f.setAttribute('action',"<?php echo init::link('opere','aggiungi'); ?>");
				f.setAttribute('name','libro_'+nr);
				var h = document.createElement("input");
				h.setAttribute('type','hidden');
				h.setAttribute('name','isbn');
				h.setAttribute('value',isbn);
				var a = document.createElement("input");
				a.setAttribute('type','text');
				a.setAttribute('name','titolo');
				a.setAttribute('value',titolo);
				var t = document.createElement("input");
				t.setAttribute('type','text');
				t.setAttribute('name','autore');
				t.setAttribute('value',autore);
				//t.setAttrubute('readOnly','readonly');
				var s = document.createElement("input");
				s.setAttribute('type',"submit");
				s.setAttribute('type',"submit");
				f.appendChild(t);
				f.appendChild(h);
				f.appendChild(a);
				f.appendChild(s);
				document.getElementById('elenco_opere').appendChild(f);
			}
        }
		if(nr == 0)
		{
			showStatus('Nessun risultato trovato');
		}
		if( 20 == nr )
		{
			showStatus('Venti! Massimo numero di risultati!');
		}
      }


      function showStatus(string) {
        var statusDiv = document.getElementById('viewerStatus');
        var showing = !(string == null || string.length == 0);
        if (statusDiv.firstChild) {
          statusDiv.removeChild(statusDiv.firstChild);
        }
        statusDiv.appendChild(document.createTextNode((showing) ? string : ''));
        statusDiv.style.display =  (showing) ? 'block' : 'none';
      }
    </script>
    <form name="inputForm"
          onsubmit="openBookByTitle(this.query.value); return false;"
          method="get">
      <input type="text" size="30" name="query" value="" />
      <input type="submit" value="Go!"/>
    </form>

    <div id="viewerStatus"
         style="padding: 5px; background-color: #eee; display: none"></div>

    <script>showStatus('Inserisci un termine di ricerca')</script>


<div id = "elenco_opere">

</div>