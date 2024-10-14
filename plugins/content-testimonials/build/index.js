/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/edit.js":
/*!*********************!*\
  !*** ./src/edit.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./editor.scss */ "./src/editor.scss");

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */


/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */



// import { DragDropContext, Droppable, Draggable } from 'react-beautiful-dnd';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
function Edit({
  attributes,
  setAttributes
}) {
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
    testimonial_style,
    testimonial_class,
    testimonial_id,
    testimonial_data_aos,
    testimonial_data_aos_delay,
    testimonial_data_aos_offset,
    testimonials
  } = attributes;
  const [value, setValue] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.useState)('');
  const addTestimonial = () => {
    setAttributes({
      testimonials: [...testimonials, {
        col_class: '',
        col_style: '',
        col_id: '',
        data_aos: 'fade-up',
        data_aos_delay: '',
        img: '',
        alt: '',
        img_style: '',
        img_class: '',
        title: '',
        content: '',
        code_block: ''
      }]
    });
  };

  // const updateTestimonial = ( testimonialIndex, field, value ) => {
  // 	setAttributes( {
  // 		testimonials: testimonials.map( ( testimonial, index ) => {
  // 			if ( index === testimonialIndex ) {
  // 				return {
  // 					...testimonial,
  // 					[ field ]: value,
  // 				};
  // 			}
  // 			return testimonial;
  // 		} ),
  // 	} );
  // };

  const updateTestimonial = (testimonialIndex, field, value) => {
    setAttributes({
      testimonials: testimonials.map((testimonial, index) => {
        if (index === testimonialIndex) {
          // Check if value is an object (for handling multiple fields like img and alt)
          if (typeof value === 'object' && value !== null) {
            return {
              ...testimonial,
              // Spread the value object to update multiple fields
              ...value
            };
          }

          // Default case: single value for a single field
          return {
            ...testimonial,
            [field]: value
          };
        }
        return testimonial;
      })
    });
  };
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.InspectorControls, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Section'),
    initialOpen: false
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Section Style",
    value: section_style,
    onChange: nextValue => setAttributes({
      section_style: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Section Class",
    value: section_class,
    onChange: nextValue => setAttributes({
      section_class: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Section ID",
    value: section_id,
    onChange: nextValue => setAttributes({
      section_id: nextValue
    })
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Background Image'),
    initialOpen: false
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.MediaUploadCheck, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.MediaUpload, {
    onSelect: media => setAttributes({
      section_image: media.url
    }),
    type: "image",
    allowedTypes: ['image'],
    value: section_image,
    render: ({
      open
    }) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, section_image && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
      isLink: true,
      isDestructive: true,
      onClick: () => setAttributes({
        section_image: ''
      })
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Remove Section Image')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
      onClick: open,
      icon: "upload",
      className: "editor-media-placeholder__button is-button is-default is-large"
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Select Section Image')))
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Background Image Class",
    value: section_image_class,
    onChange: nextValue => setAttributes({
      section_image_class: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Background Image Style",
    value: section_image_style,
    onChange: nextValue => setAttributes({
      section_image_style: nextValue
    })
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Code Block'),
    initialOpen: false
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    style: {
      lineHeight: '2'
    }
  }, "Code Block"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("textarea", {
    id: "sectionStyleTextarea",
    value: attributes.section_block,
    onChange: event => setAttributes({
      section_block: event.target.value
    }),
    placeholder: "Enter section block here",
    style: {
      width: '100%',
      height: '100px'
    }
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Container'),
    initialOpen: false
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Container Section Style",
    value: container_style,
    onChange: nextValue => setAttributes({
      container_style: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Container Section Class",
    value: container_class,
    onChange: nextValue => setAttributes({
      container_class: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Container Section ID",
    value: container_id,
    onChange: nextValue => setAttributes({
      container_id: nextValue
    })
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Row'),
    initialOpen: false
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Row Style",
    value: row_style,
    onChange: nextValue => setAttributes({
      row_style: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Row Class",
    value: row_class,
    onChange: nextValue => setAttributes({
      row_class: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Row ID",
    value: row_id,
    onChange: nextValue => setAttributes({
      row_id: nextValue
    })
  })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Testimonial Settings'),
    initialOpen: false
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Testimonial Style",
    value: testimonial_style,
    onChange: nextValue => setAttributes({
      testimonial_style: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Testimonial Class",
    value: testimonial_class,
    onChange: nextValue => setAttributes({
      testimonial_class: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Testimonial ID",
    value: testimonial_id,
    onChange: nextValue => setAttributes({
      testimonial_id: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Testimonial Data AOS",
    value: testimonial_data_aos,
    onChange: nextValue => setAttributes({
      testimonial_data_aos: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Testimonial Data AOS Delay",
    value: testimonial_data_aos_delay,
    onChange: nextValue => setAttributes({
      testimonial_data_aos_delay: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Testimonial Data AOS Offset",
    value: testimonial_data_aos_offset,
    onChange: nextValue => setAttributes({
      testimonial_data_aos_offset: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    onClick: () => addTestimonial()
  }, "Add New Testimonial")), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Column'),
    initialOpen: false
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Column Style",
    value: col_style,
    onChange: nextValue => setAttributes({
      col_style: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Column Class",
    value: col_class,
    onChange: nextValue => setAttributes({
      col_class: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Column ID",
    value: col_id,
    onChange: nextValue => setAttributes({
      col_id: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Column Data AOS",
    value: col_data_aos,
    onChange: nextValue => setAttributes({
      col_data_aos: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Column Data AOS Delay",
    value: col_data_aos_delay,
    onChange: nextValue => setAttributes({
      col_data_aos_delay: nextValue
    })
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalInputControl, {
    label: "Column Data AOS Offset",
    value: col_data_aos_offset,
    onChange: nextValue => setAttributes({
      col_data_aos_offset: nextValue
    })
  }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("section", {
    ...(0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)()
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: section_image,
    alt: ""
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    style: {
      fontSize: '24px'
    }
  }, "Inner Blocks Below"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.InnerBlocks, null), console.log('hello'), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    style: {
      fontSize: '24px'
    }
  }, "Testimonials Below"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "column-wrapper"
  }, testimonials.map((testimonial, index) => {
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: `column ${testimonial.col_class}`,
      style: {
        padding: '25px',
        borderBottom: '1px solid',
        marginBottom: '25px'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        display: 'flex'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        paddingRight: '25px'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      style: {
        marginBottom: '0px'
      }
    }, "Testimonial Class"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      type: "text",
      value: testimonial.col_class,
      onChange: content => updateTestimonial(index, 'col_class', content.target.value)
    })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        paddingRight: '25px'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      style: {
        marginBottom: '0px'
      }
    }, "Testimonial Style"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      type: "text",
      value: testimonial.col_style,
      onChange: content => updateTestimonial(index, 'col_style', content.target.value)
    })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      style: {
        marginBottom: '0px'
      }
    }, "Testimonial ID"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      type: "text",
      value: testimonial.col_id,
      onChange: content => updateTestimonial(index, 'col_id', content.target.value)
    }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        display: 'flex'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        paddingRight: '25px'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      style: {
        marginBottom: '0px'
      }
    }, "Data AOS"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      type: "text",
      value: testimonial.data_aos,
      onChange: content => updateTestimonial(index, 'data_aos', content.target.value)
    })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        paddingRight: '25px'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      style: {
        marginBottom: '0px'
      }
    }, "Data AOS Delay"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      type: "text",
      value: testimonial.data_aos_delay,
      onChange: content => updateTestimonial(index, 'data_aos_delay', content.target.value)
    }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        display: 'flex',
        justifyContent: 'space-between',
        marginTop: '25px'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        width: '49%'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
      src: testimonial.img,
      style: {
        width: '200px',
        height: 'auto'
      }
    }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.MediaUploadCheck, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.MediaUpload, {
      onSelect: media => updateTestimonial(index, 'img', {
        img: media.url,
        alt: media.alt
      }),
      type: "image",
      allowedTypes: ['image'],
      value: testimonial.img,
      render: ({
        open
      }) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, testimonial.img && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
        className: ``,
        style: {
          fontSize: '80%',
          lineHeight: '1.2'
        }
      }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Alt Text:'), " ", testimonial.alt), testimonial.img && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
        isLink: true,
        isDestructive: true,
        onClick: () => updateTestimonial(index, 'img', '')
      }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Remove Col Image')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
        onClick: open,
        icon: "upload",
        className: "editor-media-placeholder__button is-button is-default is-large"
      }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Select Col Image')))
    })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        display: 'flex'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        paddingRight: '25px',
        width: '49%'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      style: {
        marginBottom: '0px'
      }
    }, "Img Class"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      type: "text",
      style: {},
      value: testimonial.img_class,
      onChange: content => updateTestimonial(index, 'img_class', content.target.value)
    })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        width: '49%'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      style: {
        marginBottom: '0px'
      }
    }, "Img Style"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      type: "text",
      style: {},
      value: testimonial.img_style,
      onChange: content => updateTestimonial(index, 'img_style', content.target.value)
    }))), " "), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        width: '49%'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Code Block"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("textarea", {
      value: testimonial.code_block,
      onChange: content => updateTestimonial(index, 'code_block', content.target.value),
      style: {
        width: '100%',
        height: '200px'
      },
      placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Code Block')
    }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        display: 'flex',
        paddingTop: '25px'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {}
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      style: {
        marginBottom: '0px'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("strong", null, "Testimonial Content")), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText, {
      value: testimonial.content,
      onChange: content => updateTestimonial(index, 'content', content),
      placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('')
    }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      style: {
        marginBottom: '0px'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("strong", null, "Testimonial Name")), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText, {
      value: testimonial.title,
      onChange: content => updateTestimonial(index, 'title', content),
      placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('')
    }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
      style: {
        border: '1px solid'
      },
      onClick: () => {
        const newTestimonials = [...testimonials]; // Create a copy of the columns array
        const newColumn = {
          // Define a new column object
          col_class: '',
          col_style: '',
          col_id: '',
          data_aos: 'fade-up',
          data_aos_delay: '',
          img: '',
          alt: '',
          img_style: '',
          img_class: '',
          title: '',
          content: '',
          code_block: ''
        };
        newTestimonials.splice(index, 0, newColumn); // Insert the new column at the current index
        setAttributes({
          testimonials: newTestimonials
        }); // Update the columns attribute with the new array
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add Testimonial Above')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
      style: {
        border: '1px solid'
      },
      onClick: () => {
        const newTestimonials = [...testimonials]; // Create a copy of the columns array
        const newColumn = {
          // Define a new column object
          col_class: '',
          col_style: '',
          col_id: '',
          data_aos: 'fade-up',
          data_aos_delay: '',
          img: '',
          alt: '',
          img_style: '',
          img_class: '',
          title: '',
          content: '',
          code_block: ''
        };
        newTestimonials.splice(index + 1, 0, newColumn); // Insert the new column at the current index
        setAttributes({
          testimonials: newTestimonials
        }); // Update the columns attribute with the new array
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Add Testimonial Below')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
      style: {
        border: '1px solid',
        marginTop: '10px'
      },
      onClick: () => {
        const newTestimonials = [...testimonials];
        const duplicateFeature = {
          ...testimonial
        }; // Copy the testimonial object
        newTestimonials.splice(index + 1, 0, duplicateFeature); // Insert the copy after the current testimonial
        setAttributes({
          testimonials: newTestimonials
        });
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Duplicate Feature')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
      style: {
        border: '1px solid'
      },
      isDestructive: true,
      onClick: () => {
        const newTestimonials = [...testimonials];
        newTestimonials.splice(index, 1);
        setAttributes({
          testimonials: newTestimonials
        });
      }
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Remove Testimonial')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
      style: {
        border: '1px solid',
        marginTop: '10px'
      },
      onClick: () => {
        if (index === 0) return; // Prevent moving the first item up
        const newTestimonials = [...testimonials];
        const temp = newTestimonials[index - 1];
        newTestimonials[index - 1] = newTestimonials[index];
        newTestimonials[index] = temp;
        setAttributes({
          testimonials: newTestimonials
        });
      },
      disabled: index === 0 // Disable if it's the first item
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Move Up')), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
      style: {
        border: '1px solid',
        marginTop: '10px'
      },
      onClick: () => {
        if (index === testimonials.length - 1) return; // Prevent moving the last item down
        const newTestimonials = [...testimonials];
        const temp = newTestimonials[index + 1];
        newTestimonials[index + 1] = newTestimonials[index];
        newTestimonials[index] = temp;
        setAttributes({
          testimonials: newTestimonials
        });
      },
      disabled: index === testimonials.length - 1 // Disable if it's the last item
    }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Move Down')));
  }))));
}

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./src/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ "./src/save.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./block.json */ "./src/block.json");
/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */


/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * Internal dependencies
 */




/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_4__.name, {
  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"],
  /**
   * @see ./save.js
   */
  save: _save__WEBPACK_IMPORTED_MODULE_3__["default"]
});

/***/ }),

/***/ "./src/save.js":
/*!*********************!*\
  !*** ./src/save.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ save)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */




/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
function save({
  attributes
}) {
  const blockProps = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps.save();
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...blockProps
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("section", {
    className: `position-relative ${attributes.section_class}`,
    style: `padding:50px 0;${attributes.section_style}`,
    id: attributes.section_id
  }, attributes.section_image && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: attributes.section_image,
    alt: "",
    className: `w-100 h-100 position-absolute bg-img ${attributes.section_image_class}`,
    style: `top:0;left:0;object-fit:cover;pointer-events:none;${attributes.section_image_style}`
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.RawHTML, null, attributes.section_block), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: attributes.container_class,
    style: attributes.container_style,
    id: attributes.container_id
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: attributes.row_class,
    style: attributes.row_style,
    id: attributes.row_id
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: attributes.col_class,
    style: attributes.col_style,
    id: attributes.col_id,
    "data-aos": attributes.col_data_aos,
    "data-aos-delay": attributes.col_data_aos_delay,
    "data-aos-offset": attributes.col_data_aos_delay_offset
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InnerBlocks.Content, null)), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: attributes.testimonial_class,
    style: attributes.testimonial_style,
    id: attributes.testimonial_id,
    "data-aos": attributes.testimonial_data_aos,
    "data-aos-delay": attributes.testimonial_data_aos_delay,
    "data-aos-offset": attributes.testimonial_data_aos_delay_offset
  }, attributes.testimonials.map((testimonial, index) => {
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: `position-relative text-center ${testimonial.col_class}`,
      style: `${testimonial.col_style}`
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: ``,
      "data-aos": testimonial.data_aos,
      "data-aos-delay": testimonial.data_aos_delay
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: ``
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.RawHTML, null, testimonial.code_block), testimonial.img && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: '',
      style: {
        display: 'inline-block'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
      src: testimonial.img,
      alt: testimonial.alt,
      className: testimonial.img_class,
      style: `border-radius: 50%;height: 100px;width: 100px;object-fit: cover;object-position: top;${testimonial.img_style}`
    })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: `position-relative`,
      style: {
        paddingLeft: '25px'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
      src: "https://latinowebstudio.com/wp-content/uploads/2024/10/Quotes-Gray.png",
      className: `position-absolute`,
      style: "object-fit:contain;top:5px;left:0px;width:auto;",
      width: "auto",
      height: "15px",
      alt: "quotes for testimonials"
    }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      style: {
        margin: '0px'
      },
      className: `text-left`
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.RichText.Content, {
      value: testimonial.content
    })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
      src: "https://latinowebstudio.com/wp-content/uploads/2024/10/Five-Stars.png",
      style: "width:75px;margin:5px auto;",
      alt: "happy customers"
    }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      className: `bold`,
      style: {
        cursor: 'pointer'
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.RichText.Content, {
      value: testimonial.title
    }))));
  })), " "))));
}

/***/ }),

/***/ "./src/editor.scss":
/*!*************************!*\
  !*** ./src/editor.scss ***!
  \*************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/style.scss":
/*!************************!*\
  !*** ./src/style.scss ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./src/block.json":
/*!************************!*\
  !*** ./src/block.json ***!
  \************************/
/***/ ((module) => {

module.exports = /*#__PURE__*/JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"create-block/content-testimonials","version":"0.1.0","title":"Content Testimonials","category":"widgets","icon":"smiley","description":"Example block scaffolded with Create Block tool.","example":{},"supports":{"html":false},"attributes":{"section_style":{"type":"string","default":""},"section_class":{"type":"string","default":""},"section_id":{"type":"string","default":""},"section_image":{"type":"string","default":null},"section_image_class":{"type":"string"},"section_image_style":{"type":"string"},"section_block":{"type":"string","default":""},"container_style":{"type":"string","default":""},"container_class":{"type":"string","default":"container"},"container_id":{"type":"string","default":""},"row_style":{"type":"string","default":""},"row_class":{"type":"string","default":"row justify-content-center testimonial-carousel owl-carousel owl-theme"},"row_id":{"type":"string","default":""},"col_style":{"type":"string","default":"padding-bottom: 25px;"},"col_class":{"type":"string","default":"col-lg-9 text-center"},"col_id":{"type":"string","default":""},"col_data_aos":{"type":"string","default":"fade-up"},"col_data_aos_delay":{"type":"string","default":""},"col_data_aos_offset":{"type":"string","default":""},"testimonial_style":{"type":"string","default":""},"testimonial_class":{"type":"string","default":"col-lg-10 testimonial-carousel owl-carousel owl-theme"},"testimonial_id":{"type":"string","default":""},"testimonial_data_aos":{"type":"string","default":"fade-up"},"testimonial_data_aos_delay":{"type":"string","default":""},"testimonial_data_aos_offset":{"type":"string","default":""},"testimonials":{"type":"array","items":{"type":"object"},"default":[{"col_class":"","col_style":"","col_id":"","data_aos":"","data_aos_delay":"","name":"","content":""}]}},"textdomain":"content-testimonials","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css","viewScript":"file:./view.js"}');

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunkcontent_testimonials"] = globalThis["webpackChunkcontent_testimonials"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map