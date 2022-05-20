import 'package:erasmus_helper/models/cultureCategory.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class CategoryWidget extends StatelessWidget {
  final CultureCategory category;

  const CategoryWidget({Key? key, required this.category}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      width: 90,
      height: 90,
      decoration: BoxDecoration(
        border: Border.all(color: Colors.lightBlue),
        borderRadius: BorderRadius.all(Radius.circular(16)),
        color: Colors.transparent,
      ),
      child: Column(children: <Widget>[
        Icon(
          category.icon,
          color: Colors.lightBlue,
          size: 40,
        ),
        SizedBox(
          height: 10,
        ),
        Text(category.name),
      ]),
    );
  }
}
