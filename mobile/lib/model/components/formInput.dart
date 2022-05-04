import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';

class FormInput extends StatefulWidget {
  final TextInputType keyboard;
  final Icon icon;
  final String hintText;
  final FieldValidator validator;
  final bool hidable;

  const FormInput({
    Key? key,
    required this.keyboard,
    required this.icon,
    required this.hintText,
    required this.validator,
    this.hidable = false,
  }) : super(key: key);

  @override
  State<StatefulWidget> createState() => _FormInputState();
}

class _FormInputState extends State<FormInput> {
  final _formKey = GlobalKey<FormState>();
  bool _hidden = true;

  @override
  Widget build(BuildContext context) {
    return TextFormField(
        keyboardType: widget.keyboard,
        obscureText: widget.hidable ? _hidden : false,
        decoration: InputDecoration(
            icon: widget.icon,
            hintText: widget.hintText,
            suffixIcon: widget.hidable
                ? GestureDetector(
                    onTap: () {
                      setState(() {
                        _hidden = !_hidden;
                      });
                    },
                    child:
                        Icon(_hidden ? Icons.visibility : Icons.visibility_off),
                  )
                : null,),
        validator: widget.validator);
  }
}
