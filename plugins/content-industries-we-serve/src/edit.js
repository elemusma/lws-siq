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
import {
	InspectorControls,
	useBlockProps,
	InnerBlocks,
	MediaUpload,
	MediaUploadCheck,
	RichText,
} from '@wordpress/block-editor';
import {
	Button,
	PanelBody,
	__experimentalInputControl as InputControl,
	TextControl,
} from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';
// import { DragDropContext, Droppable, Draggable } from 'react-beautiful-dnd';


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
export default function Edit( { attributes, setAttributes } ) {
	const {
		section_style,
		section_class,
		section_id,
		section_image,
		section_image_class,
		section_image_style,
		section_block,
		container_style,
		container_class,
		container_id,
		row_style,
		row_class,
		row_id,
		col_style,
		col_class,
		col_id,
		col_data_aos,
		col_data_aos_delay,
		col_data_aos_offset,
		industry_style,
		industry_class,
		industry_id,
		industry_data_aos,
		industry_data_aos_delay,
		industry_data_aos_offset,
		industrys,
	} = attributes;

	const [ value, setValue ] = useState( '' );

	const addIndustry = () => {
		setAttributes( {
			industrys: [
				...industrys,
				{
					col_class: '',
					col_style: '',
					col_id: '',
					data_aos: 'fade-up',
					data_aos_delay: '',
					img: '',
					alt:'',
					img_style:'',
					img_class:'',
					title: '',
					content: '',
					code_block: ''
				},
			],
		} );
	};

	// const updateIndustry = ( industryIndex, field, value ) => {
	// 	setAttributes( {
	// 		industrys: industrys.map( ( industry, index ) => {
	// 			if ( index === industryIndex ) {
	// 				return {
	// 					...industry,
	// 					[ field ]: value,
	// 				};
	// 			}
	// 			return industry;
	// 		} ),
	// 	} );
	// };

	const updateIndustry = (industryIndex, field, value) => {
		setAttributes({
			industrys: industrys.map((industry, index) => {
				if (index === industryIndex) {
					// Check if value is an object (for handling multiple fields like img and alt)
					if (typeof value === 'object' && value !== null) {
						return {
							...industry,
							// Spread the value object to update multiple fields
							...value,
						};
					}
	
					// Default case: single value for a single field
					return {
						...industry,
						[field]: value,
					};
				}
				return industry;
			}),
		});
	};
	

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Section' ) } initialOpen={ false }>
					<InputControl
						label="Section Style"
						value={ section_style }
						onChange={ ( nextValue ) =>
							setAttributes( { section_style: nextValue } )
						}
					/>
					<InputControl
						label="Section Class"
						value={ section_class }
						onChange={ ( nextValue ) =>
							setAttributes( { section_class: nextValue } )
						}
					/>
					<InputControl
						label="Section ID"
						value={ section_id }
						onChange={ ( nextValue ) =>
							setAttributes( { section_id: nextValue } )
						}
					/>
				</PanelBody>
				<PanelBody
					title={ __( 'Background Image' ) }
					initialOpen={ false }
				>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ ( media ) =>
								setAttributes( { section_image: media.url } )
							}
							type="image"
							allowedTypes={ [ 'image' ] }
							value={ section_image }
							render={ ( { open } ) => (
								<div>
									{ section_image && (
										<Button
											isLink
											isDestructive
											onClick={ () =>
												setAttributes( {
													section_image: '',
												} )
											}
										>
											{ __( 'Remove Section Image' ) }
										</Button>
									) }
									<Button
										onClick={ open }
										icon="upload"
										className="editor-media-placeholder__button is-button is-default is-large"
									>
										{ __( 'Select Section Image' ) }
									</Button>
								</div>
							) }
						/>
					</MediaUploadCheck>

					<InputControl
						label="Background Image Class"
						value={ section_image_class }
						onChange={ ( nextValue ) =>
							setAttributes( { section_image_class: nextValue } )
						}
					/>
					<InputControl
						label="Background Image Style"
						value={ section_image_style }
						onChange={ ( nextValue ) =>
							setAttributes( { section_image_style: nextValue } )
						}
					/>
				</PanelBody>
				<PanelBody title={ __( 'Code Block' ) } initialOpen={ false }>
					<label style={ { lineHeight: '2' } }>Code Block</label>
					<textarea
						id="sectionStyleTextarea"
						value={ attributes.section_block }
						onChange={ ( event ) =>
							setAttributes( {
								section_block: event.target.value,
							} )
						}
						placeholder="Enter section block here"
						style={ { width: '100%', height: '100px' } }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Container' ) } initialOpen={ false }>
					<InputControl
						label="Container Section Style"
						value={ container_style }
						onChange={ ( nextValue ) =>
							setAttributes( { container_style: nextValue } )
						}
					/>
					<InputControl
						label="Container Section Class"
						value={ container_class }
						onChange={ ( nextValue ) =>
							setAttributes( { container_class: nextValue } )
						}
					/>
					<InputControl
						label="Container Section ID"
						value={ container_id }
						onChange={ ( nextValue ) =>
							setAttributes( { container_id: nextValue } )
						}
					/>
				</PanelBody>
				<PanelBody title={ __( 'Row' ) } initialOpen={ false }>
					<InputControl
						label="Row Style"
						value={ row_style }
						onChange={ ( nextValue ) =>
							setAttributes( { row_style: nextValue } )
						}
					/>
					<InputControl
						label="Row Class"
						value={ row_class }
						onChange={ ( nextValue ) =>
							setAttributes( { row_class: nextValue } )
						}
					/>
					<InputControl
						label="Row ID"
						value={ row_id }
						onChange={ ( nextValue ) =>
							setAttributes( { row_id: nextValue } )
						}
					/>
				</PanelBody>
				
				<PanelBody
					title={ __( 'Industry Settings' ) }
					initialOpen={ false }
				>
					<InputControl
						label="Industry Style"
						value={ industry_style }
						onChange={ ( nextValue ) =>
							setAttributes( { industry_style: nextValue } )
						}
					/>
					<InputControl
						label="Industry Class"
						value={ industry_class }
						onChange={ ( nextValue ) =>
							setAttributes( { industry_class: nextValue } )
						}
					/>
					<InputControl
						label="Industry ID"
						value={ industry_id }
						onChange={ ( nextValue ) =>
							setAttributes( { industry_id: nextValue } )
						}
					/>
					<InputControl
						label="Industry Data AOS"
						value={ industry_data_aos }
						onChange={ ( nextValue ) =>
							setAttributes( { industry_data_aos: nextValue } )
						}
					/>
					<InputControl
						label="Industry Data AOS Delay"
						value={ industry_data_aos_delay }
						onChange={ ( nextValue ) =>
							setAttributes( { industry_data_aos_delay: nextValue } )
						}
					/>
					<InputControl
						label="Industry Data AOS Offset"
						value={ industry_data_aos_offset }
						onChange={ ( nextValue ) =>
							setAttributes( { industry_data_aos_offset: nextValue } )
						}
					/>
					<button onClick={ () => addIndustry() }>
						Add New Industry
					</button>
				</PanelBody>
				<PanelBody title={ __( 'Column' ) } initialOpen={ false }>
					<InputControl
						label="Column Style"
						value={ col_style }
						onChange={ ( nextValue ) =>
							setAttributes( { col_style: nextValue } )
						}
					/>
					<InputControl
						label="Column Class"
						value={ col_class }
						onChange={ ( nextValue ) =>
							setAttributes( { col_class: nextValue } )
						}
					/>
					<InputControl
						label="Column ID"
						value={ col_id }
						onChange={ ( nextValue ) =>
							setAttributes( { col_id: nextValue } )
						}
					/>
					<InputControl
						label="Column Data AOS"
						value={ col_data_aos }
						onChange={ ( nextValue ) =>
							setAttributes( { col_data_aos: nextValue } )
						}
					/>
					<InputControl
						label="Column Data AOS Delay"
						value={ col_data_aos_delay }
						onChange={ ( nextValue ) =>
							setAttributes( { col_data_aos_delay: nextValue } )
						}
					/>
					<InputControl
						label="Column Data AOS Offset"
						value={ col_data_aos_offset }
						onChange={ ( nextValue ) =>
							setAttributes( { col_data_aos_offset: nextValue } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<section { ...useBlockProps() }>
				<img src={ section_image } alt="" />

<p style={{fontSize:'24px'}}>Inner Blocks Below</p>
<InnerBlocks />
{console.log('hello')}

<p style={{fontSize:'24px'}}>Industrys Below</p>
				<div className="column-wrapper">
					{ industrys.map( ( industry, index ) => {
						return (
							<div
								className={ `column ${ industry.col_class }` }
								style={ {
									padding: '25px',
									borderBottom: '1px solid',
									marginBottom: '25px',
								} }
							>
								<div style={{display:'flex'}}>
								<div style={{paddingRight:'25px'}}>
								<p style={ { marginBottom: '0px' } }>
									Industry Class
								</p>
								<input
									type="text"
									value={ industry.col_class }
									onChange={ ( content ) =>
										updateIndustry(
											index,
											'col_class',
											content.target.value
										)
									}
								/>
								</div>
								<div style={{paddingRight:'25px'}}>
								<p style={ { marginBottom: '0px' } }>
									Industry Style
								</p>
								<input
									type="text"
									value={ industry.col_style }
									onChange={ ( content ) =>
										updateIndustry(
											index,
											'col_style',
											content.target.value
										)
									}
								/>
								</div>
								<div>
								<p style={ { marginBottom: '0px' } }>
									Industry ID
								</p>
								<input
									type="text"
									value={ industry.col_id }
									onChange={ ( content ) =>
										updateIndustry(
											index,
											'col_id',
											content.target.value
										)
									}
								/>
								</div>
								</div>
								<div style={{display:'flex'}}>
								<div style={{paddingRight:'25px'}}>
								<p style={ { marginBottom: '0px' } }>
									Data AOS
								</p>
								<input
									type="text"
									value={ industry.data_aos }
									onChange={ ( content ) =>
										updateIndustry(
											index,
											'data_aos',
											content.target.value
										)
									}
								/>
								</div>
								<div style={{paddingRight:'25px'}}>
								<p style={ { marginBottom: '0px' } }>
									Data AOS Delay
								</p>
								<input
									type="text"
									value={ industry.data_aos_delay }
									onChange={ ( content ) =>
										updateIndustry(
											index,
											'data_aos_delay',
											content.target.value
										)
									}
								/>
								</div>
								</div>
								<div style={{display:'flex',justifyContent:'space-between',marginTop:'25px'}}>
								<div style={{width:'49%'}}>
								<img 
									src={industry.img}
									style={{width:'200px',height:'auto'}}
								/>

<MediaUploadCheck>
    <MediaUpload
        onSelect={(media) =>
            updateIndustry(index, 'img', { img: media.url, alt: media.alt })
        }
        type="image"
        allowedTypes={['image']}
        value={industry.img}
        render={({ open }) => (
            <div>
				{industry.img && (
				<p className={``} style={{fontSize:'80%',lineHeight:'1.2'}}>{__('Alt Text:')} {industry.alt}</p>
            )}
                {industry.img && (
                    <Button
                        isLink
                        isDestructive
                        onClick={() => updateIndustry(index, 'img', '')}
                    >
                        {__('Remove Col Image')}
                    </Button>
                )}
                <Button
                    onClick={open}
                    icon="upload"
                    className="editor-media-placeholder__button is-button is-default is-large"
                >
                    {__('Select Col Image')}
                </Button>
            </div>
        )}
    />
</MediaUploadCheck>


					<div style={{display:'flex'}}>
								<div style={{paddingRight:'25px',width:'49%'}}>
								<p style={ { marginBottom: '0px' } }>Img Class</p>
								<input
									type="text"
									style={{}}
									value={ industry.img_class }
									onChange={ ( content ) =>
										updateIndustry(
											index,
											'img_class',
											content.target.value
										)
									}
								/>
								
								</div>
								<div style={{width:'49%'}}>
								<p style={ { marginBottom: '0px' } }>Img Style</p>
								<input
									type="text"
									style={{}}
									value={ industry.img_style }
									onChange={ ( content ) =>
										updateIndustry(
											index,
											'img_style',
											content.target.value
										)
									}
								/>
								
								</div>
								</div> {/** end of display flex */}

					</div>
								<div style={{width:'49%'}}>
								<p>Code Block</p>
								<textarea 
								value={ industry.code_block }
								onChange={ ( content ) =>
									updateIndustry( index, 'code_block', content.target.value )
								}
								style={{width:'100%',height:'200px'}}
								placeholder={ __( 'Code Block' ) }
								/>
								</div>
								</div>

								<div
									style={ {
										display: 'flex',
										paddingTop: '25px',
									} }
								>
									<div style={ {  } }>
										<p style={{marginBottom:'0px'}}><strong>Industry Content</strong></p>
										<RichText
											value={ industry.content }
											onChange={ ( content ) =>
												updateIndustry(
													index,
													'content',
													content
												)
											}
											placeholder={ __( '' ) }
										/>
										<p style={{marginBottom:'0px'}}><strong>Industry Name</strong></p>
										<RichText
											value={ industry.title }
											onChange={ ( content ) =>
												updateIndustry(
													index,
													'title',
													content
												)
											}
											placeholder={ __( '' ) }
										/>
									</div>
								</div>
<Button
    style={{border:'1px solid'}}
    onClick={() => {
        const newIndustrys = [...industrys]; // Create a copy of the columns array
        const newColumn = { // Define a new column object
            col_class: '',
            col_style: '',
            col_id: '',
			data_aos: 'fade-up',
			data_aos_delay: '',
			img: '',
			alt:'',
			img_style:'',
			img_class:'',
			title: '',
			content: '',
			code_block: ''
        };
        newIndustrys.splice(index, 0, newColumn); // Insert the new column at the current index
        setAttributes({ industrys: newIndustrys }); // Update the columns attribute with the new array
    }}
>
    {__('Add Industry Above')}
</Button>
<Button
    style={{border:'1px solid'}}
    onClick={() => {
        const newIndustrys = [...industrys]; // Create a copy of the columns array
        const newColumn = { // Define a new column object
            col_class: '',
            col_style: '',
            col_id: '',
			data_aos: 'fade-up',
			data_aos_delay: '',
			img: '',
			alt:'',
			img_style:'',
			img_class:'',
			title: '',
			content: '',
			code_block: ''
        };
        newIndustrys.splice(index + 1, 0, newColumn); // Insert the new column at the current index
        setAttributes({ industrys: newIndustrys }); // Update the columns attribute with the new array
    }}
>
    {__('Add Industry Below')}
</Button>
{/* Duplicate Button */}
<Button
style={{ border: '1px solid', marginTop: '10px' }}
onClick={() => {
const newIndustrys = [...industrys];
const duplicateFeature = { ...industry }; // Copy the industry object
newIndustrys.splice(index + 1, 0, duplicateFeature); // Insert the copy after the current industry
setAttributes({ industrys: newIndustrys });
}}
>
{__('Duplicate Feature')}
</Button>
<Button
style={{border:'1px solid'}}
isDestructive
onClick={() => {
const newIndustrys = [...industrys];
newIndustrys.splice(index, 1);
setAttributes({ industrys: newIndustrys });
}}
>
{__('Remove Industry')}
</Button>
{/* Move Up Button */}
<Button
style={{ border: '1px solid', marginTop: '10px' }}
onClick={() => {
	if (index === 0) return; // Prevent moving the first item up
	const newIndustrys = [...industrys];
	const temp = newIndustrys[index - 1];
	newIndustrys[index - 1] = newIndustrys[index];
	newIndustrys[index] = temp;
	setAttributes({ industrys: newIndustrys });
}}
disabled={index === 0} // Disable if it's the first item
>
{__('Move Up')}
</Button>

{/* Move Down Button */}
<Button
style={{ border: '1px solid', marginTop: '10px' }}
onClick={() => {
	if (index === industrys.length - 1) return; // Prevent moving the last item down
	const newIndustrys = [...industrys];
	const temp = newIndustrys[index + 1];
	newIndustrys[index + 1] = newIndustrys[index];
	newIndustrys[index] = temp;
	setAttributes({ industrys: newIndustrys });
}}
disabled={index === industrys.length - 1} // Disable if it's the last item
>
{__('Move Down')}
</Button>
							</div>
						);
					} ) }
				</div>
			</section>
		</>
	);
}
