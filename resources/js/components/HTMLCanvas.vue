<template>
    <div id="canvas-editor" ref="canvasEditor"></div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted')
        },
        methods: {
            setCanvasEditor(){
                var drawerPlugins = ['Pencil','Eraser','Text','Line','ArrowOneSide','ArrowTwoSide',
                    'Triangle','Rectangle','Circle','Image','BackgroundImage','Polygon',
                    //'ColorHtml5',
                    'Color','ShapeBorder','BrushSize','OpacityOption','LineWidth','StrokeWidth',
                    'Resize','ShapeContextMenu','CloseButton','OvercanvasPopup','OpenPopupButton',
                    'MinimizeButton','ToggleVisibilityButton','MovableFloatingMode','TextLineHeight',
                    'TextAlign','TextFontFamily','TextFontSize','TextFontWeight','TextFontStyle',
                    'TextDecoration','TextColor','TextBackgroundColor'
                ];

                var drawer = new DrawerJs.Drawer(null, {
                    /////texts: customLocalization,
                    plugins: drawerPlugins,
                    pluginsConfig: {
                        Image: {
                            scaleDownLargeImage: true,
                            maxImageSizeKb: 1024 //1MB
                        },
                        BackgroundImage: {
                            scaleDownLargeImage: true,
                            maxImageSizeKb: 1024, //1MB
                            //fixedBackgroundUrl: '/examples/redactor/images/vanGogh.jpg',
                            imagePosition: 'stretch',  // one of  'center', 'stretch', 'top-left', 'top-right', 'bottom-left', 'bottom-right'
                            acceptedMIMETypes: ['image/jpeg', 'image/png', 'image/gif'] ,
                            dynamicRepositionImage: true,
                            dynamicRepositionImageThrottle: 100
                        },
                        Text : {
                            editIconMode : true,
                            editIconSize : 'large'
                        }
                    },
                    defaultImageUrl: '/images/drawer.jpg',
                    defaultActivePlugin : { name : 'Pencil', mode : 'lastUsed'},
                    transparentBackground: true,
                    align: 'left',  //one of 'left', 'right', 'center', 'inline', 'floating'
                    lineAngleTooltip: { enabled: true, color: 'blue',  fontSize: 15},
                }, 600, 600);
                //document.getElementById('canvas-editor').innerHTML += drawer.getHtml()
                $('#canvas-editor').append(drawer.getHtml());
                drawer.onInsert();
            },
        },
    }
</script>