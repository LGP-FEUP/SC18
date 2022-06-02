import 'package:erasmus_helper/models/culture_category.dart';
import 'package:flutter/material.dart';

class CategoryWidget extends StatelessWidget {
  final CultureCategory category;
  final bool isSelected;
  final int index;
  final Function(int) selectedCallback;

  const CategoryWidget(
      {Key? key,
      required this.category,
      required this.isSelected,
      required this.index,
      required this.selectedCallback})
      : super(key: key);

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () {
        selectedCallback(index);
      },
      child: Container(
        margin: const EdgeInsets.only(left: 5, top: 10, bottom: 10),
        width: 70,
        height: 70,
        decoration: BoxDecoration(
          border: Border.all(color: Theme.of(context).primaryColor, width: 2),
          borderRadius: const BorderRadius.all(Radius.circular(16)),
          color: isSelected ? Theme.of(context).primaryColor : Colors.white,
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Icon(
              category.icon,
              color: isSelected ? Colors.white : Theme.of(context).primaryColor,
              size: 30,
            ),
            const SizedBox(
              height: 10,
            ),
            Text(category.title,
                style:
                    TextStyle(color: isSelected ? Colors.white : Colors.black)),
          ],
        ),
      ),
    );
  }
}
