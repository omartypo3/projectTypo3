   ____________________________________________________
  /___________________________________________________/
 /_____________ Styles Marker Cluster: ______________/
/___________________________________________________/
( http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/docs/reference.html#ClusterIconStyle + ajustements min/max)

[{
	couleur: 'rose',
	url: 'EXT:e_gmap/Resources/Public/Icons/0.png',
	height: 37,
	width: 32,
	anchor: [0, 0],
	textColor: '#ffffff',
	textSize: 10,
	min: 0,
	max: 3
},
{
	couleur: 'bleu',
	url: 'EXT:e_gmap/Resources/Public/Icons/1.png',
	height: 37,
	width: 32,
	anchor: [16, 0],
	textColor: '#ff0000',
	textSize: 11,
	min: 4,
	max: 6
},
{
	couleur: 'vert',
	url: 'EXT:e_gmap/Resources/Public/Icons/2.png',
	height: 37,
	width: 32,
	anchor: [16, 0],
	textColor: '#ffffff',
	textSize: 12,
	min: 7,
	max: 15
},
{
	couleur: 'rouge',
	url: 'EXT:e_gmap/Resources/Public/Icons/3.png',
	height: 37,
	width: 32,
	anchor: [16, 0],
	textColor: '#ffffff',
	textSize: 12,
	min: 16
}]


   ____________________________________________________________________________
  /___________________________________________________________________________/
 /_____________ Pour gérer le lien vers la vue détail de news: ______________/
/___________________________________________________________________________/

<f:if condition="{infos.isEvent}">
	<f:then>
		<f:link.action action="detail" pageUid="28" controller="News" extensionName="news" pluginName="pi1" arguments="{news: infos.uid}">Plus d'infos</f:link.action>
	</f:then>
	<f:else>
		<f:link.action action="detail" pageUid="26" controller="News" extensionName="news" pluginName="pi1" arguments="{news: infos.uid}">Plus d'infos</f:link.action>
	</f:else>
</f:if>