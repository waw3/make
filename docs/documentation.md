## Minimum requirements ##

The Make WordPress theme requires WordPress 3.9 or above.

## Introduction ##

The Make WordPress provides site builder functionality to improve your experience of building a website. In the page edit screen, you can invoke a **Page builder** that assists with generating HTML for powerful page layouts. After laying out your pages, you can use the ample **Customizer options** to controls numerous aspects of your theme's look and feel. These two powerful features allow you to transform Make into any type of website that you need. 

## Page builder ##

Make provides a Page builder that assists you in generating complex HTML for diverse page layouts. The Page builder includes four distinct sections that generate layouts for different purposes. By mixing and matching different sections, you can build exciting page layouts for your website.

### Getting started with the page builder ###

To begin working with the Page builder, follow these instructions:

1. In the WordPress admin, click *Pages &rarr; Add New*.
2. You should see the **Page builder** metabox in the page edit screen.
3. If the **Page builder** metabox is not displayed, change the page template value to *Builder Template* by via the *Template* dropdown in the *Page Attributes* metabox.

### Adding a text section ###

The Page builder's **Text** section generates a multicolumn text layout.

1. Click the *Text* section in the Page builder's section menu to add a new text section.
2. Choose the number of columns to use in the section by selecting an option from the *Columns* select input. You can display between 1-4 text columns in this section.
3. Set a title for the section by entering text in the text input with the *Enter title here* placeholder text. The text section displays in above the section. You are not required to enter a title.
4. Optionally enter a link to wrap the *Featured image* and *Title* in the input with *Enter link here* placeholder text.
5. Optionally add an image to the column by clicking the *Set featured image* link or the clicking on the gray box with the image icon. In the modal window that pops up, click an existing image or drag and drop a new image onto the modal window. Click *Select* to insert the image.
6. Optionally add a title to the column by entering text into the input with the *Enter title here* placeholder text.
7. Optionally add content to the column by adding text to the WordPress editor input.
8. Repeat steps 4-7 for additional columns.
9. To rearrange the order of the columns, click and hold the double dotted border at the top of a text column. Drag the column to a new location and release.
10. Click *Save Draft*, *Publish* or *Update* to save the section.

### Adding a blank section ###

The Page builder's *Blank* section provides a free form section for adding arbitrary content to a page.

1. Click the *Blank* section in the Page builder's section menu.
2. Optionally add a title to the column by entering text into the input with the *Enter title here* placeholder text.
3. Optionally add content to the column by adding text to the WordPress editor input.

### Adding a banner section ###

The Page builder's **Banner** section generates a full width banner section that can turn into a slider if multiple slides are added.

1. Click the *Banner* section in the Page builder's section menu to add a new banner section. When adding a new banner section, an initial slide is created for you.
2. Add an image for the slide by clicking *Set slide image* or the grey box with the image icon. In the modal window that pops up, click an existing image or drag and drop a new image onto the modal window. Click *Select* to insert the image.
3. Check the box next to *Darken to improve readability* to add an overlay to the image to darken the image.
4. Set a background color *Background color* by clicking *Select color* and choosing a color. The background color will only be applied if a slide image is not set.
5. Choose a *Content position* to position where on the slide that the content will be located.
6. Add content to the WordPress editor under the *Slide content overlay* heading to add content to the slide.
7. Optionally, add additional slides by clicking *Add new slide* and repeating steps 2-6 for each slide.
8. To remove slides, click the *Remove this slide* link.

**Banner slide options**

After adding the content for your banner section, you can set the options for the section. Most of these options *only* apply to the banner sections with a slider (i.e., banner sections that have 2 or more slides).

1. Add text to the input with the *Enter title here* placeholder to set a title for the section.
2. Check the *Hide navigation arrows* box to remove the left and right navigation arrows in the slider.
3. Check the *Hide navigation dots* box to remove the navigation dots below the slider.
4. Uncheck the *Autoplay slideshow* box to remove the autoplay option from the slider.
5. Set the value for the *Time between slides (in ms)* text input to change the amount of time that each slides displays. The default is 6 seconds (6000 milliseconds).
6. Choose an option from the *Transition effect* select input to change the animation between slides.
7. Set the height of the banner section by changing the *Section height* text input. The height is in pixels (px). Note that the exact pixel value will be used when the page is displayed at full width and will be scaled proportionally as the browser window narrows.

### Adding a gallery section ###

The Page builder's **Gallery** section generates grid based gallery with optional text descriptions and captions.

1. Click the *Gallery* section in the Page builder's section menu to add a new gallery section. When adding a new gallery section, three gallery items are created for you.
2. Choose the number of columns for the gallery section using the *Columns* select input.
3. Choose the aspect ratio of the images using the *Aspect ratio* select input. For optimal display, it is recommended that you always use the same size images for each gallery item.
4. Choose the caption style for the gallery items using the *Caption style* select input. *Overlay* will display the caption on top of an image. *Reveal* will reveal the caption when hovering over an image. *None* will not display any captions.
5. Choose the caption color scheme using the *Caption color* select input. The two options will determine whether a *lighter* or *darker* overlay will be used when displaying image captions.
6. Add an image for the first gallery item by clicking *Set featured image* or the grey box with the image icon. In the modal window that pops up, click an existing image or drag and drop a new image onto the modal window. Click *Select* to insert the image.
7. Add a title to the gallery item by entering text into the input with the *Enter title here* placeholder text.
8. Add a description to the column by adding text to the textarea with the *Enter description here* placeholder text. If your image has a caption set via the media library, that will be displayed if no description text is set.
9. Add additional gallery items by clicking *Add New Item*.
10. Repeat steps 6-8 for additional gallery items.

**Gallery section options**

In the gallery section, you can configure a custom background. To add a custom background, follow these steps:

1. Add an image for the background by clicking *Set background image* or the grey box with the image icon. In the modal window that pops up, click an existing image or drag and drop a new image onto the modal window. Click *Select* to insert the image.
2. Click *Darken to improve readability* to increase the contrast between the background and the section content.
3. Choose a background style to change how the image is displayed via the *Background style* select input. *Tile* will cause the image to repeat in the X and Y direction (e.g., adds the CSS `repeat` value). *Cover* will scale the background image to completely fill the background of the element. Note that this option can lead to distortion of smaller images and cropping of bigger images.
4. If you prefer to set a background color, you can do so by clicking the *Select color* button and choosing a color. Note that if you have a background image set, it will override the background color. Click *Remove background image* to remove the background image.

## Customizer options ##

The Make WordPress theme's Customizer has numerous options to help you enhance your website's look and feel. These customization options can be leveraged to configure your site without custom code. Below, you will find helpful information for each of the sections in the customizer.

### General ###

* **Site Layout**: Sets the main column layout for the site. *Full-width* allows the main column to stretch the full width of the browser. *Boxed* sets the main column width to 1144px and centers it in the background.
* **Sticky Label**: Sets the label used in the header of sticky posts.

### Background ###

* **Background Color**: Sets the color for the background of the site. If a background image is set, the color will not be seen. Additionally, if you are using the *Full-width Site Layout* option, the background color will not be seen as it is completely covered by the main column.
* **Background Image**: Sets the background image for the site. If you are using the *Full-width Site Layout* option, the background color will not be seen as it is completely covered by the main column. After adding a background image, additional inputs for controlling CSS properties for background images will be exposed, including *Background Repeat*, *Background Position*, *Background Attachment* and *Background Size*.

### Fonts ###



