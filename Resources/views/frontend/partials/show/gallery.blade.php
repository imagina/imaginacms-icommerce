<x-media::gallery :mediaFiles="$product->mediaFiles()" :zones="['mainimage','gallery']"
                  :layout="setting('icommerce::productGalleryLayout')"
                  :dots="false" :aspectRatio="setting('icommerce::productAspect')" :loopGallery="false"
                  :responsive="setting('icommerce::productResponsive')"
/>