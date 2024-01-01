import { styled } from '../../styles'

export const NodePanel = styled('div', {
  backgroundColor: '$elevation3',
  borderRadius: '6px',
  display: 'flex',
  alignItems: 'stretch',
  justifyContent: 'space-between',
  flexDirection: 'column',
  color: '$highlight3',
  fontFamily: '$sans',
  maxWidth: '350px',
})

export const StyledTitleBar = styled('div', {
  backgroundColor: '$elevation1',
  borderRadius: '6px',
  height: '$titleBarHeight',
  color: '$highlight3',
  fontFamily: '$mono',
  fontSize: '13px',
  textAlign: 'center',
  cursor: 'grab',
})

export const NodeContent = styled('div', {
  padding: '0 18px',
  flexGrow: 1,
  overflow: 'auto',
})