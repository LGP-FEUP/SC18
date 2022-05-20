import 'package:erasmus_helper/models/cultureCategory.dart';
import 'package:erasmus_helper/views/cultural/culture_state.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class CategoryWidget extends StatelessWidget {
  final CultureCategory category;

  const CategoryWidget({Key? key, required this.category}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final cultureState = Provider.of<CultureState>(context);
    final isSelected = cultureState.selectedCategoryId == category.categoryId;

    return GestureDetector(
      onTap: () {
        if (!isSelected) {
          cultureState.updateCategoryId(category.categoryId);
        }
      },
      child: Container(
        margin: const EdgeInsets.symmetric(horizontal: 5),
        width: 90,
        height: 90,
        decoration: BoxDecoration(
          border: Border.all(
              color:
                  isSelected ? Colors.white : Color.fromARGB(255, 18, 71, 187),
              width: 3),
          borderRadius: BorderRadius.all(Radius.circular(16)),
          color: isSelected ? Color.fromARGB(255, 18, 71, 187) : Colors.white,
        ),
        child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              Icon(
                category.icon,
                color: isSelected
                    ? Colors.white
                    : Color.fromARGB(255, 18, 71, 187),
                size: 40,
              ),
              SizedBox(
                height: 10,
              ),
              Text(category.name),
            ]),
      ),
    );
  }
}
