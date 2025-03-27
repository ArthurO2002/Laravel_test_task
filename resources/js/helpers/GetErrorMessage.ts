export const getErrorMessage = (error): string => {
  if (error.response && error.response.data) {
    const { error: errorTitle, message, errors } = error.response.data

    if (errors && typeof errors === 'object') {
      const firstErrorKey = Object.keys(errors)[0]
      return errors[firstErrorKey][0]
    }

    if (message) {
      return message
    }

    if (errorTitle) {
      return errorTitle
    }
  }

  return error.message
}
