import { useState, useLayoutEffect, ReactElement } from "react";
import { createPortal } from "react-dom";

const createWrapperAndAppendToBody = (wrapperId: string) => {
  const wrapperElement = document.createElement('div')
  wrapperElement.setAttribute("id", wrapperId);
  document.body.appendChild(wrapperElement);
  return wrapperElement;
}

interface PortalProps {
  children: ReactElement
  wrapperId: string
}

export default function ReactPortal({ children, wrapperId='react-portal-wrapper' }: PortalProps){
  const [wrapperElement, setWrapperElement] = useState<HTMLElement>();

  useLayoutEffect(()=> {
    let element = document.getElementById(wrapperId);
    let systemCreated = false
    
    // if element is not found with wrapperId or wrapperId is not provided, create and append to body
    if (!element) {
      systemCreated = true;
      element = createWrapperAndAppendToBody(wrapperId);
    }
    setWrapperElement(element)

    return ()=> {
      if (systemCreated && element?.parentNode) element.parentNode.removeChild(element);
    }
  }, [wrapperId])

  // wrapperElement state will be null on very first render.
  if (!wrapperElement) return null;

  return createPortal(children, wrapperElement);
}