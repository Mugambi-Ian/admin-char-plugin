import React from 'react';
//@ts-expect-error
import { FC, FormEvent } from 'react';
import { translate } from "../utils";
import "../../css/loader.css"

interface IProps {
  onChange: (e: FormEvent<HTMLSelectElement>) => void
}
const Header: FC<IProps> = ({ onChange }) => (<div style={{ display: "flex", width: "100%" }}>
  <h2 style={{ flex: 1 }}>{translate("Graph Widget")}</h2>
  <select name="chart-admin-days" onChange={onChange} defaultValue={7}>
    <option value={7}>7 {translate("Days")}</option>
    <option value={15}>15 {translate("Days")}</option>
    <option value={30}>30 {translate("Days")}</option>
  </select>
</div>)

export default Header;    