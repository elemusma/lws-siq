/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps, InnerBlocks, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Button, PanelBody, __experimentalInputControl as InputControl,TextControl, } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';

// import MyTextComponent from './MyTextComponent';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const { section_style, section_class, section_id, section_image, section_image_alt, section_image_class, section_image_style, section_block, container_style, container_class, container_id, row_style, row_class, row_id, col_left_style, col_left_class, col_left_data_aos, col_left_data_aos_delay, col_left_data_aos_offset, col_left_id, col_right_style,col_right_class,col_right_id,col_right_data_aos, col_right_data_aos_delay, col_right_data_aos_offset, col_right_content } = attributes;

	const [value, setValue] = useState('');
	
	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Section')} initialOpen={false}>
					<InputControl
						label="Section Style"
						value={section_style}
						onChange={(nextValue) => setAttributes({ section_style: nextValue })}
					/>
					<InputControl
						label="Section Class"
						value={section_class}
						onChange={(nextValue) => setAttributes({ section_class: nextValue })}
					/>
					<InputControl
						label="Section ID"
						value={section_id}
						onChange={(nextValue) => setAttributes({ section_id: nextValue })}
					/>
					
					
				</PanelBody>
				<PanelBody title={__('Background Image')} initialOpen={false}>
				<MediaUploadCheck>
  <MediaUpload
    onSelect={(media) => setAttributes({ section_image: media.url, section_image_alt: media.alt })}
    type="image"
    allowedTypes={['image']}
    value={section_image}
    render={({ open }) => (
      <div>
        {section_image && (
          <>
            <Button
              isLink
              isDestructive
              onClick={() => setAttributes({ section_image: '', section_image_alt: '' })}
            >
              {__('Remove Section Image')}
            </Button>
            <img src={section_image} alt={section_image_alt || 'Image'} />
            {section_image_alt && (
              <p>{__('Alt Text:')} {section_image_alt}</p>
            )}
          </>
        )}
        <Button
          onClick={open}
          icon="upload"
          className="editor-media-placeholder__button is-button is-default is-large"
        >
          {__('Select Section Image')}
        </Button>
      </div>
    )}
  />
</MediaUploadCheck>

					<InputControl
						label="Background Image Class"
						value={section_image_class}
						onChange={(nextValue) => setAttributes({ section_image_class: nextValue })}
					/>
					<InputControl
						label="Background Image Style"
						value={section_image_style}
						onChange={(nextValue) => setAttributes({ section_image_style: nextValue })}
					/>
				</PanelBody>
				<PanelBody title={__('Code Block')} initialOpen={false}>
					<label style={{lineHeight:'2'}}>Code Block</label>
					<textarea
						id="sectionStyleTextarea"
						value={attributes.section_block}
						onChange={(event) => setAttributes({ section_block: event.target.value })}
						placeholder="Enter section block here"
						style={{width:'100%',height:'200px'}}
					/>
				</PanelBody>
				<PanelBody title={__('Container')} initialOpen={false}>
					<InputControl
						label="Container Section Style"
						value={container_style}
						onChange={(nextValue) => setAttributes({ container_style: nextValue })}
					/>
					<InputControl
						label="Container Section Class"
						value={container_class}
						onChange={(nextValue) => setAttributes({ container_class: nextValue })}
					/>
					<InputControl
						label="Container Section ID"
						value={container_id}
						onChange={(nextValue) => setAttributes({ container_id: nextValue })}
					/>
				</PanelBody>
				<PanelBody title={__('Row')} initialOpen={false}>
					<InputControl
						label="Row Style"
						value={row_style}
						onChange={(nextValue) => setAttributes({ row_style: nextValue })}
					/>
					<InputControl
						label="Row Class"
						value={row_class}
						onChange={(nextValue) => setAttributes({ row_class: nextValue })}
					/>
					<InputControl
						label="Row ID"
						value={row_id}
						onChange={(nextValue) => setAttributes({ row_id: nextValue })}
					/>
				</PanelBody>
				<PanelBody title={__('Column Left')} initialOpen={false}>
					<InputControl
						label="Column Style"
						value={col_left_style}
						onChange={(nextValue) => setAttributes({ col_left_style: nextValue })}
					/>
					<InputControl
						label="Column Class"
						value={col_left_class}
						onChange={(nextValue) => setAttributes({ col_left_class: nextValue })}
					/>
					<InputControl
						label="Column ID"
						value={col_left_id}
						onChange={(nextValue) => setAttributes({ col_left_id: nextValue })}
					/>
					<InputControl
						label="Data AOS"
						value={col_left_data_aos}
						onChange={(nextValue) => setAttributes({ col_left_data_aos: nextValue })}
					/>
					<InputControl
						label="Data AOS Delay"
						value={col_left_data_aos_delay}
						onChange={(nextValue) => setAttributes({ col_left_data_aos_delay: nextValue })}
					/>
					<InputControl
						label="Data AOS Offset"
						value={col_left_data_aos_offset}
						onChange={(nextValue) => setAttributes({ col_left_data_aos_offset: nextValue })}
					/>
				</PanelBody>
				<PanelBody title={__('Column Right')} initialOpen={false}>
					<InputControl
						label="Column Style"
						value={col_right_style}
						onChange={(nextValue) => setAttributes({ col_right_style: nextValue })}
					/>
					<InputControl
						label="Column Class"
						value={col_right_class}
						onChange={(nextValue) => setAttributes({ col_right_class: nextValue })}
					/>
					<InputControl
						label="Column ID"
						value={col_right_id}
						onChange={(nextValue) => setAttributes({ col_right_id: nextValue })}
					/>
					<InputControl
						label="Data AOS"
						value={col_right_data_aos}
						onChange={(nextValue) => setAttributes({ col_right_data_aos: nextValue })}
					/>
					<InputControl
						label="Data AOS Delay"
						value={col_right_data_aos_delay}
						onChange={(nextValue) => setAttributes({ col_right_data_aos_delay: nextValue })}
					/>
					<InputControl
						label="Data AOS Offset"
						value={col_right_data_aos_offset}
						onChange={(nextValue) => setAttributes({ col_right_data_aos_offset: nextValue })}
					/>
				</PanelBody>
			</InspectorControls>
			<section {...useBlockProps()} style={{background:'gray',padding:'25px 15px'}}>
				<img src={section_image} alt="" />
				{console.log(section_image)}
				<div style={{ display: 'flex' }}>
                    <div style={{ flex: '1', marginRight: '20px', width: '50%' }}>
						<InnerBlocks />
                    </div>
                    <div style={{ flex: '1', width: '50%' }}>
					<textarea
						id="colCodeTextarea"
						value={col_right_content}
						onChange={(event) => setAttributes({ col_right_content: event.target.value })}
						placeholder="Enter your content here"
						style={{width:'100%', height:'100px'}}
					/>
                    </div>
                </div>
			</section>
		</>
	);
}
